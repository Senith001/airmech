import { __ } from '@wordpress/i18n';
import { Button, Modal, TextControl, BaseControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

import ICONS from './icons';

export default function FontAwesomeIconPicker({ label, value, onChange }) {
    const [isOpen, setIsOpen] = useState(false);
    const [search, setSearch] = useState('');

    const filteredIcons = ICONS.filter(icon => icon.includes(search.toLowerCase()));

    return (
        <BaseControl label={label} className="rtmega-icon-picker-control">
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                <Button
                    variant="secondary"
                    onClick={() => setIsOpen(true)}
                    className="rtmega-icon-preview-btn"
                    style={{
                        height: '40px',
                        width: '40px',
                        display: 'flex',
                        justifyContent: 'center',
                        alignItems: 'center',
                        border: '1px solid #ccc'
                    }}
                >
                    {value ? <i className={value} style={{ fontSize: '18px' }}></i> : <span style={{ fontSize: '10px' }}>None</span>}
                </Button>
                {value && (
                    <Button
                        isSmall
                        variant="tertiary"
                        isDestructive
                        onClick={() => onChange('')}
                    >
                        {__('Clear', 'rt-mega-menu')}
                    </Button>
                )}
            </div>

            {isOpen && (
                <Modal title={__('Select Icon', 'rt-mega-menu')} onRequestClose={() => setIsOpen(false)}>
                    <div style={{ padding: '0 0 20px 0' }}>
                        <TextControl
                            placeholder={__('Search icon...', 'rt-mega-menu')}
                            value={search}
                            onChange={setSearch}
                        />
                    </div>
                    <div style={{
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(40px, 1fr))',
                        gap: '10px',
                        maxHeight: '300px',
                        overflowY: 'auto'
                    }}>
                        {filteredIcons.map(icon => (
                            <Button
                                key={icon}
                                variant={value === icon ? 'primary' : 'secondary'}
                                onClick={() => {
                                    onChange(icon);
                                    setIsOpen(false);
                                }}
                                style={{
                                    height: '40px',
                                    width: '40px',
                                    display: 'flex',
                                    justifyContent: 'center',
                                    alignItems: 'center'
                                }}
                            >
                                <i className={icon} style={{ fontSize: '16px' }}></i>
                            </Button>
                        ))}
                    </div>
                </Modal>
            )}
        </BaseControl>
    );
}