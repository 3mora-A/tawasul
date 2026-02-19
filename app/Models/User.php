<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Community;
use Illuminate\Support\Arr;


class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'faculty',
        'profile_picture',
        'cover_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessor to get full name if available.
     */
    public function getNameAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * A user can have many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Users who follow this user.
     * Example: $user->followers → returns users who follow this user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    /**
     * Users this user follows.
     * Example: $user->following → returns users this user is following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    /**
     * Check if the current user is following another user.
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Communities the user belongs to.
     */
    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_user', 'user_id', 'community_id')
                    ->withTimestamps();
    }

    /**
     * Communities created by the user.
     */
    public function createdCommunities()
    {
        return $this->hasMany(Community::class, 'creator_id');
    }

    protected static function flatFacultyOptions(): array
    {
        return array_merge(...array_values(self::facultyOptions()));
    }

    /**
     * Get the human-readable faculty name.
     */
    public function getFacultyLabelAttribute(): ?string
    {
        static $map = null;
        if (is_null($map)) {
            $map = array_merge(...array_values(self::facultyOptions()));
        }
        return $map[$this->faculty] ?? null;
    }

/**
 * قائمة الكليات مجمَّعة حسب الفئة للاستخدام في اختيارات <select>
 *
 * @return array<string, array<string, string>>
 */
public static function facultyOptions(): array
{
    return [
        'Medical & Health Sciences' => [
            'FAC01' => 'Medicine – الطب',
            'FAC03' => 'Pharmacy – الصيدلة',
            'FAC04' => 'Dentistry – طب الأسنان',
            'FAC05' => 'Nursing – التمريض',
            'FAC06' => 'Allied Health Sciences – العلوم الصحية المساندة',
            'FAC16' => 'Veterinary Medicine – الطب البيطري',
        ],
        'Engineering & Technology' => [
            'FAC02' => 'Engineering – الهندسة',
            'FAC09' => 'Computer Science & IT – علوم الحاسوب وتكنولوجيا المعلومات',
            'FAC17' => 'Architecture – العمارة',
        ],
        'Sciences & Environment' => [
            'FAC10' => 'Sciences – العلوم',
            'FAC14' => 'Agriculture & Agricultural Sciences – الزراعة والعلوم الزراعية',
            'FAC15' => 'Environmental Sciences – العلوم البيئية',
        ],
        'Arts & Humanities' => [
            'FAC11' => 'Arts & Humanities – الآداب والعلوم الإنسانية',
            'FAC13' => 'Media & Journalism – الإعلام والصحافة',
            'FAC18' => 'Design & Fine Arts – التصميم والفنون الجميلة',
        ],
        'Business & Economics' => [
            // خيار واحد يجمع إدارة الأعمال والمحاسبة والاقتصاد
            'FAC07' => 'Business & Economics – إدارة الأعمال، المحاسبة، الاقتصاد',
        ],
        'Education' => [
            'FAC12' => 'Education – التربية',
        ],
        'Languages' => [
            'FAC22' => 'Languages – اللغات',
        ],
    ];
}


// قائمة الجامعات
public static function universityOptions()
{
    return [
        'najah'       => 'An-Najah National University – جامعة النجاح الوطنية',
        'birzeit'     => 'Birzeit University – جامعة بيرزيت',
        'alquds'      => 'Al-Quds University – جامعة القدس',
        'khalil'      => 'Hebron University – جامعة الخليل',
        'khodori'     => 'Palestine Technical University – Kadoorie – جامعة فلسطين التقنية – خضوري',
        'alqods_open' => 'Al-Quds Open University – جامعة القدس المفتوحة',
        'ppu'         => 'Palestine Polytechnic University – جامعة بوليتكنك فلسطين',
        'aaup'        => 'Arab American University – الجامعة العربية الأمريكية',
        'istaqlal'    => 'Al-Istiqlal University – جامعة الاستقلال',
    ];
    
}



// Getter لعرض اسم الجامعة
public function getUniversityNameAttribute()
{
    return self::universityOptions()[$this->university] ?? 'No university specified';
}


public function communityPosts()
{
    return $this->hasMany(\App\Models\CommunityPost::class);
}


}
