<?php
function display_error($validators,$field)
{
    if(isset($validators))
    {
        if($validators->hasError($field))
        {
            return $validators->getError($field);
        }
        else
        {
            return false;
        }
    }
}