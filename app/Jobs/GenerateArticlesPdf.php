<?php

namespace App\Jobs;

use App\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class GenerateArticlesPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $html;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string  $html)
    {
        $this->html=$html;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd($this->html);
        $pdf = PDF::loadHTML($this->html);
        return $pdf->download(Carbon::now()->year.'-'.Carbon::now()->month.'-'.Carbon::now()->day.'.pdf');
    }
}
