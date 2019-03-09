<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Null_;

class Post extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['title','slug','excerpt','body','published_at','category_id','image'];
    protected  $dates = ['published_at'];
    
    public function author()
    {
      return $this->belongsTo('App\User');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function createComment(array $data)
    {
        $this->comments()->create($data);
    }
    
    public function commentsNumber($label = 'Comment')
    {
        $commentsNumber = $this->comments->count();
        
        return $commentsNumber." ". str_plural($label, $commentsNumber);
    }

    public function getImageUrlAttribute($value)
    {
      $imageUrl = "";
       if (! is_null($this->image)) {
           
           $directory = config('cms.image.directory');
           $imagePath = public_path() . "/{$directory}/" . $this->image;
           if (file_exists($imagePath)) {
               $imageUrl = asset("{$directory}/" . $this->image);
           }
       }
       return $imageUrl;
    }
    
    public function getImageThumbUrlAttribute($value)
    {
        $imageUrl = "";
        if (! is_null($this->image)) {
            
            $directory = config('cms.image.directory');
            $ext = substr(strrchr($this->image,"."),1);
            
            $thumbnil = str_replace(".{$ext}","_thumb.{$ext}",$this->image);
            
            $imagePath = public_path() . "/{$directory}/" . $thumbnil;
            if (file_exists($imagePath)) {
                $imageUrl = asset("{$directory}/" . $thumbnil);
            }
        }
        return $imageUrl;
    }

    public function getDateAttribute($value)
    {
      return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();
    }
    
    public function getBodyHtmlAttribute($value)
    {
        return $this->body ?  Markdown::convertToHtml(e($this->body)) : NULL;
    }
    
    public function getExcerptHtmlAttribute($value)
    {
        return $this->excerpt ?  Markdown::convertToHtml(e($this->excerpt)) : NULL;
    }
    
    public function getTagsHtmlAttribute()
    {
        $anchor = [];
        foreach($this->tags as $tag){
            $anchor[] = '<a href="'. route('tag',$tag->slug) .'">'. $tag->name .'</a>';
        }
        return implode(",",$anchor);
    }
    
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: NULL;
    }
    
    public function dateFormatted($showTime = false)
    {
        $format = "d/m/Y";
        if($showTime) $format = $format . "H:i:s";
        return $this->created_at->format($format);
    }
    
    public function publicationLabel()
    {
        if (! $this->published_at)
        {
            return '<span class="label label-warning">Draft</span>';
            
        }elseif ($this->published_at && $this->published_at->isFuture()){
            
            return '<span class="label label-info">Schedule</span>';
        }else{
            return '<span class="label label-success">Published</span>';
        }
    }
    
    public function scopeLatestFirst($query)
     {
         return $query->orderBy('published_at', 'desc');
     }
    
    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }
    
    public function scopePublished($query)
    {
        return $query->where("published_at", "<=", Carbon::now());
    }
    
    public function scopeScheduled($query)
    {
        return $query->where("published_at", ">", Carbon::now());
    }
    
    public function scopeDraft($query)
    {
        return $query->whereNull("published_at");
    }
    
    public static function archives()
    {
        return static::selectRaw('count(id) as post_count, year(published_at) year, monthname(published_at) month')
            ->published()
            ->groupBy('year','month')
            ->orderByRaw('min(published_at) desc')
            ->get();
    }
    
    public function scopeFilter($query, $filter)
    {
        if (isset($filter['month']) && $month = $filter['month'])
        {
            $query->whereRaw('month(published_at) = ? ', [Carbon::parse($month)->month]);
        }
    
        if (isset($filter['year']) && $year = $filter['year'])
        {
            $query->whereRaw('year(published_at) = ? ', [$year]);
        }
        //if check term found
        if (isset($filter['term']) && $term = $filter['term'])
        {
            $query->where(function ($q) use ($term){
                $q->whereHas('author',function ($qr) use ($term){
                   $qr->where('name','LIKE',"%{$term}%");
                });
                $q->orWhereHas('category',function ($qr) use ($term){
                    $qr->where('slug','LIKE',"%{$term}%");
                });
                $q->orWhere('title','LIKE',"%{$term}%");
                $q->orWhere('excerpt','LIKE',"%{$term}%");
            });
        }
    }
}
