<div class="rts-tab-style-one">
    <div class="d-flex align-items-start contoler-company">
        <div class="nav flex-column nav-pills me-3 button-area" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <?php
            $unique = rand(2012,3554120);
            $x = 0;
            $y = 1;
            foreach ( $tabs as $index => $item ) :
                $x++;
                $span = $y++;

                if($x == 1){
                    $active_tab = 'active';
                }else{
                    $active_tab = '';
                }

                $tab_count = $index + 1;
                $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title' ],
                    'data-tab' => $tab_count,
                    'role' => 'tab',
                    'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                ] );

                $icon = !empty($item['tab_icon']) ? '<i class="'.$item['tab_icon'].'"></i>': '';
                
                $titleimg    = !empty($item['selected_image']['url']) ? '<img src="'. $item['selected_image']['url']. '" />' : '';
                ?>           

                <button class="nav-link <?php echo $active_tab;?>" id="v-pills<?php echo esc_html($x);?><?php echo esc_html($unique);?>" data-bs-toggle="pill" data-bs-target="#v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" type="button" role="tab" aria-controls="v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" aria-selected="false"><?php echo esc_html($item['tab_title']); ?></button>
            <?php endforeach; ?>                    
            
           
        </div>

        <div class="tab-content" id="v-pills-tabContent">
        
            <?php
                $x = 0;
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;
                    $x++;
                    if($x == 1){
                        $active_tab = 'active show';
                    }else{
                        $active_tab = '';
                    }
                    $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                    $tab_title_mobile_setting_key = $this->get_repeater_setting_key( 'tab_title_mobile', 'tabs', $tab_count );

                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-content', 'elementor-clearfix' ],
                        'data-tab' => $tab_count,
                        'role' => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ] );

                    $this->add_render_attribute( $tab_title_mobile_setting_key, [
                        'class' => [ 'elementor-tab-title', 'elementor-tab-mobile-title' ],
                        'data-tab' => $tab_count,
                        'role' => 'tab',
                    ] );

                    $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );                       
                    ?>                
                  
                    <div class="tab-pane fade <?php echo esc_attr($active_tab);?>" id="v-<?php echo esc_html($x);?><?php echo esc_html($unique);?>" role="tabpanel" aria-labelledby="v-pills-<?php echo esc_html($x);?><?php echo esc_html($unique);?>">
                    <!-- start tab content -->
                    <div class="rts-tab-content-one">
                        <?php echo $this->parse_text_editor( $item['tab_content'] ); ?> 
                        <a class="rts-btn btn-primary-2 color-h-black" href="#"><?php echo $item['btn_text'];?></a>
                    </div>
                    <!-- start tab content End -->
                   
                </div>
            <?php endforeach; ?>
           
            
        </div>
    </div>
</div>