<?php

namespace Elegant\Admin\Tree\Actions;

use Elegant\Admin\Actions\TreeAction;

class Show extends TreeAction
{
    /**
     * @return array|null|string
     */
    public function name()
    {
        return admin_trans('show');
    }

    /**
     * @return string
     */
    protected function icon()
    {
        return 'fa-eye';
    }

    /**
     * @return string
     */
    public function href()
    {
        return "{$this->getResource()}/{$this->getKey()}";
    }
}
