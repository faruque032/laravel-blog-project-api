<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Welcome to Our Laravel Blog',
                'content' => 'This is our first blog post! We are excited to share our thoughts and experiences with Laravel development. Laravel is a powerful PHP framework that makes web development enjoyable and creative. With its elegant syntax and robust features, Laravel has become one of the most popular PHP frameworks in the world.',
                'excerpt' => 'Welcome to our brand new Laravel blog! Learn about what makes Laravel special.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'Welcome to Our Laravel Blog - Getting Started',
                'meta_description' => 'Welcome to our Laravel blog where we share insights about web development, best practices, and tutorials.',
            ],
            [
                'title' => 'Building Modern Web Applications with Laravel',
                'content' => 'Laravel provides a comprehensive set of tools for building modern web applications. From Eloquent ORM for database interactions to Blade templating engine for beautiful views, Laravel has everything you need. In this post, we explore the key features that make Laravel stand out from other PHP frameworks.',
                'excerpt' => 'Explore the powerful features of Laravel that make it perfect for modern web development.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'meta_title' => 'Modern Web Applications with Laravel Framework',
                'meta_description' => 'Learn how to build modern web applications using Laravel\'s powerful features and elegant syntax.',
            ],
            [
                'title' => 'Best Practices for Laravel Development',
                'content' => 'Following best practices is crucial for maintaining clean, scalable, and secure Laravel applications. This includes proper validation, using service classes, implementing proper error handling, and following SOLID principles. We also cover performance optimization techniques and security considerations.',
                'excerpt' => 'Learn essential best practices for Laravel development to build better applications.',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'meta_title' => 'Laravel Development Best Practices Guide',
                'meta_description' => 'Essential best practices for Laravel development including security, performance, and code organization.',
            ],
            [
                'title' => 'Understanding Eloquent ORM Relationships',
                'content' => 'Eloquent ORM is one of Laravel\'s most powerful features. It provides an intuitive way to work with database relationships including one-to-one, one-to-many, and many-to-many relationships. In this comprehensive guide, we explore how to define and use these relationships effectively in your Laravel applications.',
                'excerpt' => 'Master Eloquent ORM relationships to build powerful database-driven applications.',
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'meta_title' => 'Eloquent ORM Relationships in Laravel',
                'meta_description' => 'Complete guide to understanding and implementing Eloquent ORM relationships in Laravel applications.',
            ],
            [
                'title' => 'Laravel Security Best Practices',
                'content' => 'Security should be a top priority in any web application. Laravel provides many built-in security features, but developers need to know how to use them properly. This post covers input validation, XSS protection, CSRF tokens, SQL injection prevention, and other important security considerations.',
                'excerpt' => 'Essential security practices every Laravel developer should follow.',
                'status' => 'draft',
                'published_at' => null,
                'meta_title' => 'Laravel Security Best Practices for Developers',
                'meta_description' => 'Learn essential security practices to protect your Laravel applications from common vulnerabilities.',
            ],
            [
                'title' => 'Optimizing Laravel Application Performance',
                'content' => 'Performance optimization is crucial for providing a great user experience. Laravel offers various optimization techniques including query optimization, caching strategies, eager loading, and more. This post provides a comprehensive guide to making your Laravel applications faster and more efficient.',
                'excerpt' => 'Learn how to optimize your Laravel applications for better performance.',
                'status' => 'draft',
                'published_at' => null,
                'meta_title' => 'Laravel Performance Optimization Techniques',
                'meta_description' => 'Complete guide to optimizing Laravel application performance with caching, query optimization, and more.',
            ],
        ];

        foreach ($posts as $postData) {
            $postData['slug'] = Str::slug($postData['title']);
            BlogPost::create($postData);
        }
    }
}
