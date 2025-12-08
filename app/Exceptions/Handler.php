<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\RedirectResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Handle CSRF token mismatch gracefully so users see a friendly message
        if ($exception instanceof TokenMismatchException) {
            // Log for diagnostics
            \Log::warning('CSRF token mismatch (TokenMismatchException) detected for URL: ' . $request->fullUrl());

            // Redirect back with input and a helpful message
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Your session has expired. Please try again.']);
        }

        return parent::render($request, $exception);
    }
}
