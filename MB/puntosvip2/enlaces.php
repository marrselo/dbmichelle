<div class="enlaces">
    <?php
    foreach ($arrayMenu AS $key => $value):
        $class = ($key == 'catalogodetalle.php') ? 'boton especial' : 'boton';
        ?>
        <div class="<?php echo $class ?>">
            <a href="<?php echo $key ?>">
                <img alt="" 
                     width="<?php echo ($class=='boton especial')?300:286?>" 
                     <?php if($key == 'establecimientos_afiliados.php'): ?>
                      height="77" width="286" src="<?php echo $value ?>" />
                     <?php else:?>
                     height="<?php echo ($class=='boton especial')?46:36?>" src="<?php echo $value ?>" />
                     <?php endif;?>
            </a>
        </div>
<?php endforeach; ?>    
</div>
