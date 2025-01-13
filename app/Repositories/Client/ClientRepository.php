<?php

namespace App\Repositories\Client;

use App\Helper\Helper;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ClientRepository implements ClientInterface
{
  use Helper;
  protected $client;

  public function __construct(User $client)
  {
    $this->client = $client;
  }

  public function getMainClient()
  {
    return $this->client->with('addresses.country')->latest()->paginate();
  }

  public function updatePassword($data, $id)
  {
    $client = $this->client->findOrFail($id);
    $client->update($data);
  }

  public function update($data, $id)
  {
    $client = $this->client->findOrFail($id);
    $client->update($data);

    return $client->wasChanged();
  }

  public function delete($id)
  {
    $client = User::findOrFail($id);
    $client->delete();
  }
}
