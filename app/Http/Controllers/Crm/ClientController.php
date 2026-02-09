<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Resources\Crm\TaskResource;
use App\Models\Crm\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function __invoke(Client $client): AnonymousResourceCollection
    {
        $clientTasks = $client->tasks()->with(['client','user'])->latest()->paginate(16);


        return TaskResource::collection($clientTasks);
    }
}
