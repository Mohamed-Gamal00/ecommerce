<?php

namespace App\Repositories\Banner;

use App\Helper\Helper;

use App\Models\Design;
use App\Models\HeaderBanner;
use Illuminate\Support\Facades\Storage;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete .
*/

class HeaderBannerRepository implements HeaderBannerInterface
{

    use Helper;

    public $banner;

    public function __construct(HeaderBanner $banner)
    {
        $this->banner = $banner;  // Ready-instance model of Design
    }

    public function getMainDesign()
    {
        return $this->banner::orderByRaw('main_banar IS NULL, main_banar ASC')->paginate();
    }

    public function getHomeBanners()
    {
        return $this->banner->all();
    }

    public function getOfferBageBanners()
    {
        return $this->banner->where('page_name', 'offers-page')->get();
    }

    public function store($data)
    {
        return $this->banner->create($data);
    }

    public function update($data, $id)
    {
        $banner = $this->getById($id);
        $banner->update($data);

        return $banner->wasChanged();
    }

    public function getById($id)
    {
        return $this->banner->findOrFail($id);
    }

    public function delete($id)
    {
        $banner = $this->banner->findOrFail($id);

        $banner->delete();
    }
}
