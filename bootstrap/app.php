<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
      'admin' => \App\Http\Middleware\IsAdmin::class,
      'admin-speaker' => \App\Http\Middleware\IsAdminSpeaker::class,
      'owner-presentation-edit' =>
        \App\Http\Middleware\IsOwnerPresentationEdit::class,
      'owner-presentation-create' =>
        \App\Http\Middleware\IsOwnerPresentationCreate::class,
      'owner-poster-create' => \App\Http\Middleware\IsOwnerPosterCreate::class,
      'owner-poster-edit' => \App\Http\Middleware\IsOwnerPosterEdit::class,
      'published-poster-show' =>
        \App\Http\Middleware\IsPublishedPosterShow::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    //
  })
  ->create();
