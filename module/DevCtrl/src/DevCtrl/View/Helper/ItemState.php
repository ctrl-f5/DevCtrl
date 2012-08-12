<?php

namespace DevCtrl\View\Helper;

use Ctrl\View\Helper\AbstractHtmlElement;
use DevCtrl\Domain\Item\State\State;

class ItemState extends AbstractHtmlElement
{
    public function __invoke(State $state = null)
    {
        if (!$state) return '';

        $class = '';
        if ($state->getNativeState() == State::getNativeStates(State::STATE_OPEN))      $class = 'label-success';
        if ($state->getNativeState() == State::getNativeStates(State::STATE_BLOCKED))   $class = 'label-warning';
        if ($state->getNativeState() == State::getNativeStates(State::STATE_CLOSED))    $class = 'label-inverse';
        $html = '<span class="label '.$class.'">'.$state->getLabel().'</span>';

        return $html;
    }

    protected function create($title, $subtitle = null, $attr = array())
    {
        $html = '<h1'.
            $this->_htmlAttribs(
                $this->_cleanupAttributes(
                    array_merge_recursive($this->defaulTitleAttributes, $attr)
                )
            ).'">'.
            $title.
            '</h1>';
        if ($subtitle) {
            $html .= '<h2>'.$subtitle.'</h2>';
        }
        return $html;
    }
}
