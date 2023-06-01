<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Image;

class CropImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:crop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crop images and keep ratio';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $bar = $this->output->createProgressBar(10);
        $bar->start();

        $imageSourcePath = 'samplefolder';
        $imagedestinationPath = 'outputfolder';

        $sourceFiles = Storage::disk('public')->files($imageSourcePath);
        $croppedImages = Storage::disk('public')->files($imagedestinationPath);

        $counter = 0;
        foreach ($sourceFiles as $file) {

            $destinationFile = $imagedestinationPath . '/' . basename($file);
            if (in_array($destinationFile, $croppedImages)) {
                continue;
            }

            $croppedImage = Image::make(Storage::disk('public')->path($file))
                ->fit(100, 100)
                ->encode();

            Storage::disk('public')->put($destinationFile, $croppedImage);

            $bar->advance();
    

            $counter++;
            if ($counter === 10) {
                break;
            }
        }

        $bar->finish();
        $this->line('');
        $this->info('Command executed successfully.');
        return Command::SUCCESS;


    }
}
