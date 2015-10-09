<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.07.2015
 * Time: 15:33
 */

class base_pages_news_view_MainPage extends View
{
    /**
     * display the content of this View
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $od->addContent(Html::startTag('div', ['class' => 'news']));
        /** @var News $news */
        foreach ($this->controller->getModelData() as $news) {
            /** @var base_date_model_DateTime $firstEditTime */
            $firstEditTime = $news['firstEditTime'];
            $table = new base_html_model_Table();
            $table->setCssClass('news');
            $table->setId(get_class($news) . '_' . $news->getLogicalKey());
            $row = new base_html_model_table_Row();
            $row->setRowType(base_html_model_table_Row::ROWTAG_HEAD);
            $timeCell = new base_html_model_table_Cell();
            $timeCell->setCssClass('firstEditorTime');
            $timeCell->setContent($firstEditTime->display('d.m.y'));
            $titleCell = new base_html_model_table_Cell();
            $titleCell->setCssClass('title');
            $titleCell->setContent($news['title']);
            $row->addCell($timeCell);
            $row->addCell($titleCell);
            $table->addHeadRow($row);
            $this->_createContentRow($news, $table);
            $od->addContent($table->toString());
        }
        $od->addContent(Html::endTag('div'));
    }

    /**
     * @param $news
     * @param $table
     * @return base_html_model_table_Row
     * @throws base_html_model_Exception
     */
    private function _createContentRow(News $news, base_html_model_Table $table)
    {
        $content = $news['content'];
        if (strlen($content) > 400) {
            $content = $this->_shortenContent($content);
        }
        $row = new base_html_model_table_Row();
        $contentCell = new base_html_model_table_Cell();
        $contentCell->setCssClass('content');
        $contentCell->setContent($content);
        $contentCell->setColSpan(2);
        $row->addCell($contentCell);
        $table->addRow($row);
        return $row;
    }

    /**
     * @param $content
     * @return string
     */
    private function _shortenContent($content)
    {
        $contentParts = str_split($content, 400);
        $contentShow = $contentParts[0]
            . Html::startTag('span', ['class' => 'show'])
            . '... '
            . Html::url('#', 'mehr', ['class' => 'show'])
            . Html::endTag('span');

        $contentHide = Html::startTag('span', ['class' => 'hide'])
            . $contentParts[1]
            . Html::endTag('span');
        $content = $contentShow . $contentHide;
        return $content;
    }

}