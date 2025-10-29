<?php
namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ProfilePage extends Page
{
    protected static string $resource = 'App\\Filament\\Resources\\UserResource';
    protected static string $view = 'filament.resources.user-resource.pages.profile-page';

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

}
