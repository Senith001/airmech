import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { useBlockProps, InspectorControls, BlockControls, AlignmentToolbar } from '@wordpress/block-editor';
import { ToggleControl, SelectControl, PanelBody, Spinner, TabPanel, __experimentalDivider as Divider, __experimentalBoxControl as BoxControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

// Import custom components
import ColorPopover from './components/ColorPopover';
import BackgroundControl from './components/BackgroundControl';
import TypographyControls from './components/TypographyControls';
import BoxShadowControls from './components/BoxShadowControls';
import ResponsiveWrapper from './components/ResponsiveWrapper';
import CustomRangeControl from './components/CustomRangeControl';
import FontAwesomeIconPicker from './components/FontAwesomeIconPicker';

export default function Edit({ attributes, setAttributes }) {
    const {
        menu_slug,
        menu_layout,
        submenu_icon_style,
        vertical_active_menu_style,
        vertical_menu_arrow_type,
        enable_vertical_menu_arrow,
        enable_vertical_menu_arrow_right,
        vertical_menu_expand_mode,
        vertical_menu_expand_position,
        vertical_menu_expand_overlay_position,
        vertical_menu_toggle_icon,
        vertical_menu_close_icon,
        pointer_menu_item,
        menuAlign,
        enableMobileMenu,
        mobileMenuIcon,
        mobileMenuOpenPosition
    } = attributes;

    const { menus, hasResolved } = useSelect((select) => {
        const { getEntityRecords, hasFinishedResolution } = select('core');
        const query = { per_page: -1 };
        return {
            menus: getEntityRecords('taxonomy', 'nav_menu', query),
            hasResolved: hasFinishedResolution('getEntityRecords', ['taxonomy', 'nav_menu', query]),
        };
    }, []);

    const menuOptions = [
        { label: __('Select Menu', 'rt-mega-menu'), value: '' },
        ...(menus || []).map((menu) => ({
            label: menu.name,
            value: menu.slug,
        })),
    ];

    const getAttrKey = (base, device) => {
        if (device === 'desktop') return base;
        return `${base}${device.charAt(0).toUpperCase() + device.slice(1)}`;
    };

    const blockProps = useBlockProps();

    return (
        <>
            <BlockControls>
                <AlignmentToolbar
                    value={menuAlign}
                    onChange={(newAlign) => setAttributes({ menuAlign: newAlign })}
                />
            </BlockControls>

            <InspectorControls>
                {/* Menu Settings Panel */}
                <PanelBody title={__('Menu Settings', 'rt-mega-menu')}>
                    {!hasResolved ? (
                        <Spinner />
                    ) : (
                        <SelectControl
                            label={__('Select Menu', 'rt-mega-menu')}
                            value={menu_slug}
                            options={menuOptions}
                            onChange={(newMenuSlug) => setAttributes({ menu_slug: newMenuSlug })}
                            help={__('Go to Appearance > Menus to manage your menus.', 'rt-mega-menu')}
                        />
                    )}
                    <SelectControl
                        label={__('Menu Layout', 'rt-mega-menu')}
                        value={menu_layout}
                        options={[
                            { label: __('Horizontal', 'rt-mega-menu'), value: 'horizontal' },
                            { label: __('Vertical', 'rt-mega-menu'), value: 'vertical' },
                        ]}
                        onChange={(newLayout) => setAttributes({ menu_layout: newLayout })}
                    />
                    {
                        menu_layout === 'horizontal' && (
                            <SelectControl
                                label={__('Sub Menu Icon Style', 'rt-mega-menu')}
                                value={submenu_icon_style}
                                options={[
                                    { label: __('Icon 1 (Down Arrow)', 'rt-mega-menu'), value: 'icon1' },
                                    { label: __('Icon 2 (Plus)', 'rt-mega-menu'), value: 'icon2' },
                                    { label: __('Icon 3 (Right Arrow)', 'rt-mega-menu'), value: 'icon3' },
                                ]}
                                onChange={(newIcon) => setAttributes({ submenu_icon_style: newIcon })}
                            />
                        )
                    }

                    <SelectControl
                        label={__('Hover Effect', 'rt-mega-menu')}
                        value={pointer_menu_item}
                        options={[
                            { label: __('None', 'rt-mega-menu'), value: 'none' },
                            { label: __('Underline', 'rt-mega-menu'), value: 'underline' },
                            { label: __('Overline', 'rt-mega-menu'), value: 'overline' },
                            { label: __('Double Line', 'rt-mega-menu'), value: 'double-line' },
                        ]}
                        onChange={(newPointer) => setAttributes({ pointer_menu_item: newPointer })}
                    />
                </PanelBody>
                {menu_layout === 'vertical' && (
                    <PanelBody title={__('Vertical Menu', 'rt-mega-menu')}>
                        <SelectControl
                            label={__('Vertical Menu Expand Mode', 'rt-mega-menu')}
                            value={vertical_menu_expand_mode}
                            options={[
                                { label: __('Click', 'rt-mega-menu'), value: 'click' },
                                { label: __('Always Expand', 'rt-mega-menu'), value: 'always_expand' },
                            ]}
                            onChange={(newExpandMode) => setAttributes({ vertical_menu_expand_mode: newExpandMode })}
                        />
                        <FontAwesomeIconPicker
                            label={__('Vertical Menu Toggle Icon', 'rt-mega-menu')}
                            value={vertical_menu_toggle_icon}
                            onChange={(value) => setAttributes({ vertical_menu_toggle_icon: value })}
                        />
                        <FontAwesomeIconPicker
                            label={__('Vertical Menu Close Icon', 'rt-mega-menu')}
                            value={vertical_menu_close_icon}
                            onChange={(value) => setAttributes({ vertical_menu_close_icon: value })}
                        />
                        <SelectControl
                            label={__('Vertical Menu Expand Position', 'rt-mega-menu')}
                            value={vertical_menu_expand_position}
                            options={[
                                { label: __('Overlay', 'rt-mega-menu'), value: 'top' },
                                { label: __('Bottom', 'rt-mega-menu'), value: 'bottom' },
                                { label: __('Left', 'rt-mega-menu'), value: 'left' },
                                { label: __('Right', 'rt-mega-menu'), value: 'right' },
                            ]}
                            onChange={(newExpandPosition) => setAttributes({ vertical_menu_expand_position: newExpandPosition })}
                        />
                        <SelectControl
                            label={__('Vertical Menu Expand Overlay Position', 'rt-mega-menu')}
                            value={vertical_menu_expand_overlay_position}
                            options={[
                                { label: __('Top', 'rt-mega-menu'), value: 'top' },
                                { label: __('Bottom', 'rt-mega-menu'), value: 'bottom' },
                                { label: __('Left', 'rt-mega-menu'), value: 'left' },
                                { label: __('Right', 'rt-mega-menu'), value: 'right' },
                            ]}
                            onChange={(newExpandOverlayPosition) => setAttributes({ vertical_menu_expand_overlay_position: newExpandOverlayPosition })}
                        />
                        <ToggleControl
                            label={__('Enable Vertical Menu Arrow', 'rt-mega-menu')}
                            checked={enable_vertical_menu_arrow}
                            onChange={(newEnableVerticalMenuArrow) => setAttributes({ enable_vertical_menu_arrow: newEnableVerticalMenuArrow })}
                        />
                        {enable_vertical_menu_arrow && (
                            <ToggleControl
                                label={__('Enable Vertical Menu Arrow Right', 'rt-mega-menu')}
                                checked={enable_vertical_menu_arrow_right}
                                onChange={(newEnableVerticalMenuArrowRight) => setAttributes({ enable_vertical_menu_arrow_right: newEnableVerticalMenuArrowRight })}
                            />
                        )}
                        <SelectControl
                            label={__('Vertical Active Menu Style', 'rt-mega-menu')}
                            value={vertical_active_menu_style}
                            options={[
                                { label: __('Icon 1 (Angle)', 'rt-mega-menu'), value: 'icon1' },
                                { label: __('Icon 2 (Plus)', 'rt-mega-menu'), value: 'icon2' },
                                { label: __('Icon 3 (Arrow Right)', 'rt-mega-menu'), value: 'icon3' },
                            ]}
                            onChange={(newIcon) => setAttributes({ vertical_active_menu_style: newIcon })}
                        />
                        <SelectControl
                            label={__('Vertical Active Arrow Type', 'rt-mega-menu')}
                            value={vertical_menu_arrow_type}
                            options={[
                                { label: __('Single Arrow', 'rt-mega-menu'), value: 'rtmega-single-arrow' },
                                { label: __('Double Arrow', 'rt-mega-menu'), value: 'rtmega-double-arrow' },
                                { label: __('Custom Icon', 'rt-mega-menu'), value: 'custom-icon' },
                            ]}
                            onChange={(newIcon) => setAttributes({ vertical_menu_arrow_type: newIcon })}
                        />
                    </PanelBody>
                )
                }
                <PanelBody title={__('Responsive Menu', 'rt-mega-menu')}>
                    <ToggleControl
                        label={__('Enable Responsive Menu', 'rt-mega-menu')}
                        checked={enableMobileMenu}
                        onChange={(value) => setAttributes({ enableMobileMenu: value })}
                    />
                    {enableMobileMenu && (
                        <>
                            <FontAwesomeIconPicker
                                label={__('Responsive Menu Toggle Icon', 'rt-mega-menu')}
                                value={mobileMenuIcon}
                                onChange={(value) => setAttributes({ mobileMenuIcon: value })}
                            />
                            <SelectControl
                                label={__('Responsive Menu Open Position', 'rt-mega-menu')}
                                value={mobileMenuOpenPosition}
                                options={[
                                    { label: __('Left', 'rt-mega-menu'), value: 'left' },
                                    { label: __('Right', 'rt-mega-menu'), value: 'right' },
                                    { label: __('Top', 'rt-mega-menu'), value: 'top' }
                                ]}
                                onChange={(newPosition) => setAttributes({ mobileMenuOpenPosition: newPosition })}
                            />
                        </>
                    )}
                </PanelBody>
            </InspectorControls>

            {/* Style Controls */}
            <InspectorControls group="styles">
                {/* 1. Menu Style (Wrap) */}
                <PanelBody title={__('Main Menu', 'rt-mega-menu')} initialOpen={true}>
                    <BackgroundControl
                        label={__('Background', 'rt-mega-menu')}
                        colorValue={attributes.wrapperBgColor}
                        gradientValue={attributes.wrapperBgGradient}
                        onColorChange={(color) => setAttributes({ wrapperBgColor: color, wrapperBgGradient: '' })}
                        onGradientChange={(gradient) => setAttributes({ wrapperBgGradient: gradient, wrapperBgColor: '' })}
                    />
                    <Divider />
                    <ResponsiveWrapper label={__('Alignment', 'rt-mega-menu')}>
                        {(device) => (
                            <SelectControl
                                value={attributes[getAttrKey('menuAlign', device)] || 'left'}
                                onChange={(val) => setAttributes({ [getAttrKey('menuAlign', device)]: val })}
                                options={[
                                    { label: __('Left', 'rt-mega-menu'), value: 'left' },
                                    { label: __('Center', 'rt-mega-menu'), value: 'center' },
                                    { label: __('Right', 'rt-mega-menu'), value: 'right' },
                                ]}
                            />
                        )}
                    </ResponsiveWrapper>
                    <ResponsiveWrapper label={__('Space Between', 'rt-mega-menu')}>
                        {(device) => (
                            <CustomRangeControl
                                //label={__('Space Between', 'rt-mega-menu')}
                                value={attributes[getAttrKey('menuSpaceBetween', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('menuSpaceBetween', device)]: value })}
                                min={0}
                                max={100}
                            />
                        )}
                    </ResponsiveWrapper>

                    <Divider />

                    <ResponsiveWrapper label={__('Padding', 'rt-mega-menu')}>
                        {(device) => (
                            <BoxControl
                                //label={__('Padding', 'rt-mega-menu')}
                                values={attributes[getAttrKey('wrapperPadding', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('wrapperPadding', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>

                    <ResponsiveWrapper label={__('Margin', 'rt-mega-menu')}>
                        {(device) => (
                            <BoxControl
                                //label={__('Margin', 'rt-mega-menu')}
                                values={attributes[getAttrKey('wrapperMargin', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('wrapperMargin', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                {/* 2. Menu Item Styles */}
                <PanelBody title={__('Main Menu Item', 'rt-mega-menu')} initialOpen={false}>
                    <TabPanel
                        className="rtmega-style-tabs"
                        activeClass="is-active"
                        tabs={[
                            { name: 'normal', title: __('Normal', 'rt-mega-menu') },
                            { name: 'hover', title: __('Hover', 'rt-mega-menu') },
                        ]}
                    >
                        {(tab) => (
                            <div style={{ marginTop: '15px' }}>
                                {tab.name === 'normal' ? (
                                    <>
                                        <ColorPopover
                                            label={__('Text Color', 'rt-mega-menu')}
                                            color={attributes.menuItemColor}
                                            onChange={(color) => setAttributes({ menuItemColor: color })}
                                        />
                                        <BackgroundControl
                                            label={__('Background', 'rt-mega-menu')}
                                            colorValue={attributes.menuItemBgColor}
                                            gradientValue={attributes.menuItemBgGradient}
                                            onColorChange={(color) => setAttributes({ menuItemBgColor: color, menuItemBgGradient: '' })}
                                            onGradientChange={(gradient) => setAttributes({ menuItemBgGradient: gradient, menuItemBgColor: '' })}
                                        />
                                    </>
                                ) : (
                                    <>
                                        <ColorPopover
                                            label={__('Text Color (Hover)', 'rt-mega-menu')}
                                            color={attributes.menuItemHoverColor}
                                            onChange={(color) => setAttributes({ menuItemHoverColor: color })}
                                        />
                                        <BackgroundControl
                                            label={__('Background (Hover)', 'rt-mega-menu')}
                                            colorValue={attributes.menuItemHoverBgColor}
                                            gradientValue={attributes.menuItemHoverBgGradient}
                                            onColorChange={(color) => setAttributes({ menuItemHoverBgColor: color, menuItemHoverBgGradient: '' })}
                                            onGradientChange={(gradient) => setAttributes({ menuItemHoverBgGradient: gradient, menuItemHoverBgColor: '' })}
                                        />
                                    </>
                                )}
                            </div>
                        )}
                    </TabPanel>

                    <Divider />

                    <ResponsiveWrapper label={__('Typography', 'rt-mega-menu')}>
                        {(device) => (
                            <TypographyControls
                                // label={__('Typography', 'rt-mega-menu')}
                                attributes={attributes}
                                setAttributes={setAttributes}
                                attributeKey={getAttrKey('menuTypography', device)}
                            />
                        )}
                    </ResponsiveWrapper>

                    <Divider />

                    <ResponsiveWrapper label={__('Padding', 'rt-mega-menu')}>
                        {(device) => (
                            <BoxControl
                                //label={__('Padding', 'rt-mega-menu')}
                                values={attributes[getAttrKey('menuPadding', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('menuPadding', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>

                    <ResponsiveWrapper label={__('Margin', 'rt-mega-menu')}>
                        {(device) => (
                            <BoxControl
                                //label={__('Margin', 'rt-mega-menu')}
                                values={attributes[getAttrKey('menuMargin', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('menuMargin', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                {/* 3. Sub Menu Styles */}
                <PanelBody title={__('Sub Menu', 'rt-mega-menu')} initialOpen={false}>
                    <BackgroundControl
                        label={__('Background', 'rt-mega-menu')}
                        colorValue={attributes.submenuBgColor}
                        gradientValue={attributes.submenuBgGradient}
                        onColorChange={(color) => setAttributes({ submenuBgColor: color, submenuBgGradient: '' })}
                        onGradientChange={(gradient) => setAttributes({ submenuBgGradient: gradient, submenuBgColor: '' })}
                    />

                    <BoxShadowControls
                        attributes={attributes}
                        setAttributes={setAttributes}
                        state="normal"
                    />

                    <Divider />
                    <ResponsiveWrapper label={__('Space Between', 'rt-mega-menu')}>
                        {(device) => (
                            <CustomRangeControl
                                //label={__('Space Between', 'rt-mega-menu')}
                                value={attributes[getAttrKey('subMenuSpaceBetween', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('subMenuSpaceBetween', device)]: value })}
                                min={0}
                                max={100}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                {/* 4. Sub Menu Item Style */}
                <PanelBody title={__('Sub Menu Item', 'rt-mega-menu')} initialOpen={false}>
                    <TabPanel
                        className="rtmega-style-tabs"
                        activeClass="is-active"
                        tabs={[
                            { name: 'normal', title: __('Normal', 'rt-mega-menu') },
                            { name: 'hover', title: __('Hover', 'rt-mega-menu') },
                        ]}
                    >
                        {(tab) => (
                            <div style={{ marginTop: '15px' }}>
                                {tab.name === 'normal' ? (
                                    <>
                                        <ColorPopover
                                            label={__('Text Color', 'rt-mega-menu')}
                                            color={attributes.submenuItemColor}
                                            onChange={(color) => setAttributes({ submenuItemColor: color })}
                                        />
                                        <ColorPopover
                                            label={__('Background Color', 'rt-mega-menu')}
                                            color={attributes.submenuItemBgColor}
                                            onChange={(color) => setAttributes({ submenuItemBgColor: color })}
                                        />
                                    </>
                                ) : (
                                    <>
                                        <ColorPopover
                                            label={__('Text Color (Hover)', 'rt-mega-menu')}
                                            color={attributes.submenuItemHoverColor}
                                            onChange={(color) => setAttributes({ submenuItemHoverColor: color })}
                                        />
                                        <ColorPopover
                                            label={__('Background Color (Hover)', 'rt-mega-menu')}
                                            color={attributes.submenuItemHoverBgColor}
                                            onChange={(color) => setAttributes({ submenuItemHoverBgColor: color })}
                                        />
                                    </>
                                )}
                            </div>
                        )}
                    </TabPanel>

                    <Divider />

                    <TypographyControls
                        label={__('Typography', 'rt-mega-menu')}
                        attributes={attributes}
                        setAttributes={setAttributes}
                        attributeKey="submenuTypography"
                    />
                    <Divider />

                    <ResponsiveWrapper label={__('Padding', 'rt-mega-menu')}>
                        {(device) => (
                            <BoxControl
                                //label={__('Padding', 'rt-mega-menu')}
                                values={attributes[getAttrKey('submenuItemPadding', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('submenuItemPadding', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

            </InspectorControls>

            <div {...blockProps}>
                {!menu_slug ? (
                    <div className="rt-mega-menu-placeholder">
                        {__('Select a menu from the settings', 'rt-mega-menu')}
                    </div>
                ) : (
                    <ServerSideRender
                        block="rt-mega-menu/mega-menu"
                        attributes={attributes}
                    />
                )}
            </div>
        </>
    );
}
