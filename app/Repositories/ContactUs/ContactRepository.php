<?php

namespace App\Repositories\ContactUs;

use App\Helper\Helper;
use App\Models\ContactUs;

class ContactRepository implements ContactInterface
{
  use Helper;
  protected $contact;

  public function __construct(ContactUs $contact)
  {
    $this->contact = $contact;
  }

  public function getAll()
  {
    return $this->contact->latest()->paginate();
  }

  public function show($id)
  {
    return $this->contact->findOrFail($id);
  }
}
