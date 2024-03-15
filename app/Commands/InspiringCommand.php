<?php
namespace Me42th\Coddle\Commands;
use Me42th\Coddle\Traits\InspireTrait;

class InspiringCommand extends DefaultCommand {
    use InspireTrait;

    static $name = 'inspire';
    static $description = 'Inspiration stuff';
    static $help = 'Inspire you when everything is hard';
    static $args = ['?arg:The arg of the user']; //* ?
    static $options = ['?opt,o:The opt of the user']; //* ? -

    public function handle():void
    {
        $this->info(env('teste'));
        $this->info($this->action());
    }
}