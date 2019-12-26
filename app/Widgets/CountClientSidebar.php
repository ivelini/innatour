<?php

namespace App\Widgets;

use App\Repositories\ClientsRepository;
use Arrilot\Widgets\AbstractWidget;

class CountClientSidebar extends AbstractWidget
{

    protected $clientsRepository;
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->clientsRepository = new ClientsRepository();
    }

    public function run()
    {
        if ($this->config[0] == 'new') {
            $count = $this->clientsRepository->getCountStatusNew();
            $status = 'new';
        }
        elseif ($this->config[0] == 'active') {
            $count = $this->clientsRepository->getCountStatusActive();
            $status = 'active';
        }
        elseif ($this->config[0] == 'closed') {
            $count = $this->clientsRepository->getCountStatusClosed();
            $status = 'closed';
        }

        return view('admin.widgets.CountClientSidebar', compact('count', 'status'));
    }
}
