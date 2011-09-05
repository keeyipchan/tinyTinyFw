<?php
$widgets->let('toggleButton', function() {
    $template = new widget();
    $template->expect('states');
    $template->expect('type');
    $template->expect('content', array(
        'default' => 'Test'
    ));
    $template->let('fontSize', 10);
    $template->let('width', 10);
    $template->let('type:CLOSE', function($self) {
        return str::equals('close', $self->get('type'));
    });
    $template->let('normalBg', function($self) {
        return $self->get('type:CLOSE') ? 'hsl(0,30%,40%)' : 'hsl(200,30%,35%)';
    });
    $template->let('normalBorder', function($self) {
        $normalBorder = $self->get('type:CLOSE')? 'solid 2px hsl(200,40%,80%)'
            : 'solid 2px hsl(200,40%,35%)';
    });
    $template->let('hoverBorder',
        'solid 2px hsl(50,80%,80%)'
    );
    $template->let('dom', function($self) {
        $dom = new dom('a');
        $dom->jsCall('toggler', array(
            'states' => $self->get('states'),
            'currentIndex' => 0
        ));
        $dom->attr('data-widget', 'toggleButton');
        $dom->attr('onmouseover', "this.style.border = '$hoverBorder'; this.style.letterSpacing = '1px';");
        $dom->attr('onmouseout', "this.style.border = '$normalBorder'; this.style.letterSpacing = '2px';");
        $dom->css(array(
            'width' => $self->get('width') . 'em',
            'cursor' => "default",
            '-webkit-border-radius' => $self->get('type:CLOSE') ? '0 8px 0 20px' : '4px 4px 0 0',
            'display' => 'inline-block',
            'vertical-align' => 'text-top',
            'letter-spacing' => '2px',
            'text-align' => 'center',
            'font-size' => $self->get('fontSize') . 'px',
            'padding' => $self->get('type:CLOSE') ? '2px 0px 4px 4px' : '2px 0',
            'border' => $self->get('normalBorder'),
            'color' => $self->get('type:CLOSE') ? 'hsl(200,40%,85%)' : 'hsl(200,40%,80%)',
            'margin' => $self->get('type:CLOSE') ? '1px' : '0 8px',
            'background' => $self->get('normalBg')
        ));
        return $dom;
    });
    return $template;
});
$widgets->let('window', function() {
    $template = new widget();
    $template->expect('content');
    $template->let('dom', function($self) {
        $dom = new dom('div');
        $dom->css(array(
            'position' => 'relative',
            '-webkit-border-radius' => '8px',
            'border-bottom' => 'solid 2px hsl(200,35%,55%)',
            'background' => 'hsl(200,35%,75%)',
            'padding' => '0',
            'overflow' => 'hidden'
        ));
        $dom->append(
            dom('div')->css(array(
                'float' => 'right',
                'margin' => '0',
                'padding' => '0'
            ))->append(widget('toggleButton')->let('states', array('Close'))->let('type', 'close')),
            dom('div')->css(array(
                'position' => 'absolute',
                'right' => '0',
                'bottom' => '0',
                'margin' => '0',
                'padding' => '0'
            ))->append(widget('toggleButton')->let('states', array('Fullscreen', 'Inline'))),
            dom('div')->css(array(
                'padding' => '1em',
                'padding-bottom' => '10em'
            ))->append($self->get('content'))
        );
        return $dom;
    });
    return $template;
});
?>