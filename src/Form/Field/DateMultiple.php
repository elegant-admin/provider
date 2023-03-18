<?php

namespace Elegant\Admin\Form\Field;

class DateMultiple extends Text
{
    protected static $css = [
        'vendor/elegant-admin/flatpickr/dist/flatpickr.min.css',
        'vendor/elegant-admin/flatpickr/dist/themes/light.min.css',

    ];

    protected static $js = [
        'vendor/elegant-admin/flatpickr/dist/flatpickr.min.js',
        'vendor/elegant-admin/flatpickr/dist/shortcut-buttons-flatpickr.min.js',
        'vendor/elegant-admin/flatpickr/dist/l10n/zh.js',
    ];

    protected $format = 'YYYY-MM-DD';

    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function render()
    {
        $this->options['format'] = $this->format;
        $this->options['locale'] = array_key_exists('locale', $this->options) ? $this->options['locale'] : config('app.locale');
        $this->options['allowInputToggle'] = true;

        $this->script = "$('{$this->getElementClassSelector()}').flatpickr({mode: 'multiple',dateFormat: 'Y-m-d', locale: 'zh', plugins: [
            ShortcutButtonsPlugin({
              button: {
                label: 'Clear',
              },
              onClick: (index, fp) => {
                fp.clear();
                fp.close();
              }
            })
          ]});";

        $this->prepend('<i class="fa fa-calendar fa-fw"></i>')
            ->defaultAttribute('style', 'width: 100%');

        return parent::render();
    }
}
