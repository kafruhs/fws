<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 15:27
 */

class Html
{
    /**
     * creates an start tag
     *
     * @param string    $tagName
     * @param array     $attributes
     * @return string
     */
    public static function startTag($tagName, $attributes = array())
    {
        $tag = "<$tagName ";
        $tag .=self::_getAttributesString($attributes);
        $tag .= '>';
        return $tag;
    }

    /**
     * creates an end tag
     *
     * @param string    $tagName
     * @return string
     */
    public static function endTag($tagName)
    {
        return "</$tagName>\n";
    }

    /**
     * @param $attributes
     * @return string
     */
    private static function _getAttributesString($attributes)
    {
        $attributeString = '';
        foreach ($attributes as $attibuteKey => $attributeValue) {
            $attributeString .= "$attibuteKey='$attributeValue' ";
        }
        return $attributeString;
    }

    /**
     * generates an a tag
     *
     * @param string    $link
     * @param string    $display
     * @param array     $attributes
     * @return string
     */
    public static function url($link, $display, $attributes = array())
    {
        $attributes['href'] = $link;
        $link = self::startTag('a', $attributes);
        $link .= $display;
        $link .= self::endTag('a');
        return $link;
    }

    /**
     * extend a given attribute in the attribute list entered by function call
     *
     * @param $attributeName
     * @param $attributeValue
     * @param array $attributes
     * @return array
     */
    public static function extendAttributeIfExists($attributeName, $attributeValue, array $attributes)
    {
        if (isset($attributes[$attributeName]) === true) {
            $attributes[$attributeName] .= " $attributeValue";
        } else {
            $attributes[$attributeName] = $attributeValue;
        }
        return $attributes;
    }

    /**
     * @param $tagName
     * @param array $params
     * @return string
     */
    public static function singleTag($tagName, $params = array())
    {
        return "<$tagName " . Html::_getAttributesString($params) . " />";
    }

    /**
     * display a box for ajax call messages
     *
     * @param null|string $content
     * @return string
     */
    public static function ajaxMsgDiv($content = null)
    {
        $msg = self::closingButtonForAjaxMsgBox();
        if ($content == null) {
            $msg .= self::startTag('p');
            $msg .= self::img('loader.gif', array('width' => '300px'));
            $msg .= '<br />Ihre Anfrage wird bearbeitet.';
            $msg .= self::endTag('p');
            $class = 'ajaxMsgHide';
        } else {
            $msg .= $content;
            $class = 'ajaxMsgShow';
        }
        $div = self::startTag('div', array('id' => 'ajaxMsg', 'class' => $class));
        $div .=  $msg;
        $div .= self::endTag('div');
        return $div;
    }
    /**
     * display a box for ajax call messages
     *
     * @param null|string $content
     * @return string
     */
    public static function loaderDiv()
    {
        $msg = self::startTag('p');
        $msg .= self::img('loader.gif', array('width' => '100px'));
        $msg .= '<br />Ihre Anfrage wird bearbeitet.';
        $msg .= self::endTag('p');
        $class = 'ajaxMsgHide';
        $div = self::startTag('div', array('id' => 'loader', 'class' => $class));
        $div .=  $msg;
        $div .= self::endTag('div');
        return $div;
    }

    /**
     * performs a closing button in the right top edge of the parent element for closing
     *
     * @return string
     */
    public static function closingButtonForAjaxMsgBox()
    {
        $closingButton = self::startTag('div', array('class' => 'closeButton'));
        $closingButton .= self::pictogram('cross', array('class' => 'closingButton', 'id' => 'closeAjaxMsg'));
        $closingButton .= self::endTag('div');
        return $closingButton;
    }


    /**
     * returns a tag for an pictogram
     *
     * @param string    $pictogramName  Name of the pictogram in the images/pictograms folder without file-extension
     * @param array     $attributes
     * @return string
     */
    public static function pictogram($pictogramName, $attributes = array())
    {
        $attributes = self::extendAttributeIfExists('class', 'pictogram', $attributes);
        return self::img("pictogram/$pictogramName.png", $attributes);

    }

    /**
     * set image-tag
     *
     * @param string $src       path relativ to the image folder
     * @param array  $params
     * @param string $altname
     *
     * @return string
     */
    public static function img($src, $params = array(), $altname = '')
    {
        $params['src'] = HTML_ROOT . '/images/' . $src;
        $img = self::startTag('img', $params) . $altname . self::endTag('img');
        return $img;
    }
} 