<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id','user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        
        $its_me = $this->id == $userId;
        
        if($exist || $its_me){
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
             $this->followings()->detach($userId);
             return true;
        }else{
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    public function feed_books()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Book::whereIn('user_id', $follow_user_ids);
    }
    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'book_id')->withTimestamps();
    }
    
   
    public function favorite($bookId)
    {
        $exist = $this->is_favorite($bookId);

        if ($exist) {
            return false;
        }else{
            $this->favorites()->attach($bookId);
            return true;
        }
    }
    
    public function unfavorite($bookId)
    {
        $exist = $this->is_favorite($bookId);
        
        if ($exist) {
            $this->favorites()->detach($bookId);
            return true;
        }else{
            return false;
        }
    }
    public function is_favorite($bookId)
    {
        return $this->favorites()->where('book_id', $bookId)->exists();
    }
}
