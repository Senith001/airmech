import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import {
    SelectControl,
    TextControl,
    Popover,
    Button,
    Icon
} from '@wordpress/components';

const TypographyControls = ({ label, attributes, setAttributes, attributeKey, nextDefaultSize }) => {
    const [isVisible, setIsVisible] = useState(false);
    const typography = attributes[attributeKey] || {};

    const _nextDefaultSize = nextDefaultSize || false;

    const toggleVisible = () => {
        setIsVisible((state) => !state);
    };

    const updateTypography = (newAttrs) => {
        const nextTypography = {
            ...typography,
            ...newAttrs
        };

        setAttributes({
            [attributeKey]: nextTypography
        });
    };

    return (
        <div className="eshb-typography-control" style={{ position: 'relative' }}>
            <Button
                variant="secondary"
                onClick={toggleVisible}
                style={{ width: '100%', justifyContent: 'space-between', marginBottom: '15px', boxShadow: 'none' }}
            >
                {label}
                <Icon icon="edit" />
            </Button>
            {isVisible && (
                <Popover
                    position="bottom center"
                    onFocusOutside={() => setIsVisible(false)}
                >
                    <div style={{ padding: '20px', width: '260px' }}>
                        <TextControl
                            label={__('Font Size', 'rt-mega-menu')}
                            value={typography.fontSize}
                            onChange={(val) => updateTypography({ fontSize: val })}
                            help={__('Include unit (e.g., 14px, 1.2rem)', 'rt-mega-menu')}
                        />
                        <SelectControl
                            label={__('Font Weight', 'rt-mega-menu')}
                            value={typography.fontWeight}
                            options={[
                                { label: __('Default', 'rt-mega-menu'), value: 'inherit' },
                                { label: __('Thin (100)', 'rt-mega-menu'), value: '100' },
                                { label: __('Light (300)', 'rt-mega-menu'), value: '300' },
                                { label: __('Regular (400)', 'rt-mega-menu'), value: '400' },
                                { label: __('Medium (500)', 'rt-mega-menu'), value: '500' },
                                { label: __('Semi Bold (600)', 'rt-mega-menu'), value: '600' },
                                { label: __('Bold (700)', 'rt-mega-menu'), value: '700' },
                                { label: __('Extra Bold (800)', 'rt-mega-menu'), value: '800' },
                                { label: __('Black (900)', 'rt-mega-menu'), value: '900' },
                            ]}
                            onChange={(val) => updateTypography({ fontWeight: val })}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                        <SelectControl
                            label={__('Text Transform', 'rt-mega-menu')}
                            value={typography.textTransform}
                            options={[
                                { label: __('None', 'rt-mega-menu'), value: 'none' },
                                { label: __('Uppercase', 'rt-mega-menu'), value: 'uppercase' },
                                { label: __('Lowercase', 'rt-mega-menu'), value: 'lowercase' },
                                { label: __('Capitalize', 'rt-mega-menu'), value: 'capitalize' },
                            ]}
                            onChange={(val) => updateTypography({ textTransform: val })}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                        <TextControl
                            __next40pxDefaultSize={_nextDefaultSize}
                            label={__('Line Height', 'rt-mega-menu')}
                            value={typography.lineHeight}
                            onChange={(val) => updateTypography({ lineHeight: val })}
                        />
                        <TextControl
                            __next40pxDefaultSize={_nextDefaultSize}
                            label={__('Letter Spacing', 'rt-mega-menu')}
                            value={typography.letterSpacing}
                            onChange={(val) => updateTypography({ letterSpacing: val })}
                            help={__('Include unit (e.g., 1px)', 'rt-mega-menu')}
                        />
                        <Button
                            variant="secondary"
                            isSmall
                            onClick={() => {
                                setAttributes({
                                    [attributeKey]: {
                                        fontSize: '',
                                        fontWeight: 'inherit',
                                        lineHeight: '',
                                        textTransform: 'none',
                                        letterSpacing: ''
                                    }
                                });
                                setIsVisible(false);
                            }}
                            style={{ marginTop: '10px', width: '100%', justifyContent: 'center' }}
                        >
                            {__('Reset Typography', 'rt-mega-menu')}
                        </Button>
                    </div>
                </Popover>
            )}
        </div>
    );
};

export default TypographyControls;
