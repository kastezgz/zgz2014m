<?php

/**
 * Dibuja el formulario
 * @param array $form
 */
function renderForm($form, $action, $method='post', $upload = FALSE) 
{
    $result = '<form method="'.$method.'" 
                     action="'.$action.'"';
        if($upload)
                $result.= ' ENCTYPE="multipart/form-data"';
    $result .=  '>';
    
    foreach ($form as $field) 
    {
        $result .= '<p>';
        if (!empty($field['label'])) $result .= '<label>'. $field['label'] . ' </label> ';
        if (!empty($field['hint'])) $result .= ' - ' . $field['hint'] . '<br/>';
        
        switch ($field['type']) 
        {
            case 'text':
            case 'password':
            case 'button':
            case 'submit':
            case 'file':
                $result .= '<input type="' . $field['type'] . '"' . renderOpts($field) . '/>';
            break;
            case 'textarea':
                $result .= '<textarea' . renderOpts($field, ['name', 'placeholder']) . '>';
                if (!empty($field['value'])) $result .= $field['value'];
                $result .= '</textarea>';
            break;
            case 'radio':
                foreach ($field['options'] as $key => $value)
                {
                    $result .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" value="' . $key . '"';
                    if (in_array($key, $field['value'])) $result .= ' checked';
                    $result .= "/>$value";
                }
            break;
            case 'checkbox':
                foreach ($field['options'] as $key => $value) 
                {
                    $result .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '[]" value="' . $key . '"';
                    if (in_array($key, $field['value'])) $result .= ' checked';
                    $result .= "/>$value";
                }
            break;
            case 'select':
                $result .= '<select';
                if ($field['type'] == 'selectmultiple') ;
                $result .= ' name="' . $field['name'] . '">';
                foreach ($field['options'] as $key => $value)
                {
                    $result .= '<option value="' . $key . '"';
                    if (in_array($key, $field['value'])) $result .= ' selected';
                    $result .= ">$value</option>";
                }
                $result .= '</select>';
            break;
            case 'selectmultiple':
                $result .= '<select';
                if ($field['type'] == 'selectmultiple') $result .= ' multiple';
                $result .= ' name="' . $field['name'] . '[]">';
                foreach ($field['options'] as $key => $value) 
                {
                    $result .= '<option value="' . $key . '"';
                    if (in_array($key, $field['value'])) $result .= ' selected';
                    $result .= ">$value</option>";
                }
                $result .= '</select>';
            break;
        }
        $result .= '</p>';
    }
    
    $result .= '</form>';
    
    return $result;
}


/**
 * Dibuja las opciones del campo
 * @param array $field
 * @param array $opts
 */
function renderOpts($field, $opts=['name', 'value', 'placeholder']) 
{
    $result = '';
    foreach ($opts as $key) 
    {
        if (!empty($field[$key])) $result .= ' ' . $key . '="' . $field[$key] . '"'; 
    }
    
    return $result;
}
