<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph;

use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Modules\Chart\Datas\ChartData;
use Spatie\QueueableAction\QueueableAction;

class GetGraphAction
{
    use QueueableAction;

    public function execute(ChartData $chartData): Graph
    {
        $graph = new Graph($chartData->width, $chartData->height, 'auto');
        $graph->SetScale('textlin');
        $graph->SetShadow();

        $universalTheme = new UniversalTheme;

        $graph->SetTheme($universalTheme);

        if (isset($chartData->min)) {
            $graph->yscale->SetAutoMin($chartData->min);
        }

        if (isset($chartData->max)) {
            $graph->yscale->SetAutoMax($chartData->max);
        }

        if ($chartData->title !== null) {
            $graph->title->Set($chartData->title);
            $graph->title->SetFont($chartData->font_family, $chartData->font_style, 11);
        }

        if ($chartData->subtitle !== null) {
            $graph->subtitle->Set($chartData->subtitle);
            $graph->subtitle->SetFont($chartData->font_family, $chartData->font_style, 11);
        }

        if ($chartData->footer !== null) {
            $graph->footer->center->Set($chartData->footer);
            $graph->footer->center->SetFont($chartData->font_family, $chartData->font_style, 10);
        }

        $graph->SetBox($chartData->show_box);

        $graph->footer->right->SetFont($chartData->font_family, $chartData->font_style);

        $this->applyGraphXStyle($graph->xaxis, $chartData);
        $this->applyGraphYStyle($graph->yaxis, $chartData);

        return $graph;
    }

    public function applyGraphXStyle(Axis &$axis, ChartData $chartData): void
    {
        $axis->SetFont($chartData->font_family, $chartData->font_style, $chartData->font_size);
        $axis->SetLabelAngle($chartData->x_label_angle);
        // Some extra margin looks nicer
        $axis->SetLabelMargin($chartData->x_label_margin);
        // Label align for X-axis
        // $graph->xaxis->SetLabelAlign('right', 'center');
    }

    public function applyGraphYStyle(Axis &$axis, ChartData $chartData): void
    {
        // Add some grace to y-axis so the bars doesn't go
        // all the way to the end of the plot area
        // "restringe" la visualizzazione delle barre
        $axis->scale->SetGrace($chartData->y_grace);
        // dddx($style['yaxis_hide']);
        // We don't want to display Y-axis
        // visualizza delle colonne verticali "in sottofondo/di riferimento"
        // if (null == $data->yaxis_hide || 0 == $data->yaxis_hide) {
        if ($chartData->yaxis_hide) {
            $axis->Hide();
        }

        $axis->HideZeroLabel();
        $axis->HideLine(false);
        $axis->HideTicks(false, false);
    }
}
