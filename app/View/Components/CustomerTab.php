<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomerTab extends Component
{
    public $customers;
    public $customergroups;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($customers, $customergroups)
    {
        $this->customers = $customers;
        $this->customergroups = $customergroups;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer-tab');
    }
}
