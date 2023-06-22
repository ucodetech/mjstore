<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\TemporaryFile;
use Illuminate\Support\Carbon;


class removeTmpFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'removeTmp:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove temporary files in all tmp folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        //delete Temporary files 
        $tmp_file = TemporaryFile::where('date_created', '<' ,Carbon::now())->get();
        if(count($tmp_file)>0){
            foreach($tmp_file as $file){
                $file->delete();
            }
        }

        //delete the golder
        $folder1 = 'uploads/products/tmp';
        $folder2 = 'uploads/products/category/tmp';
        $folder3 = 'uploads/brands/tmp';
        $folder4 = 'uploads/banners/tmp';
        $folders = [$folder1, $folder2, $folder3, $folder4];
        if($folders){
            foreach($folders as $folder){
                Storage::deleteDirectory($folder);
            }
        }
        
       

        
    }
}
