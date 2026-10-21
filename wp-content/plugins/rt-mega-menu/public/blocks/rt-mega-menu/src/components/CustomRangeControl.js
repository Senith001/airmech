import { __ } from '@wordpress/i18n';
import { RangeControl, SelectControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

export default function CustomRangeControl({ label, value, onChange, min = 0, max = 100 }) {

    // Helper to parse "10px", "1.5rem" => { num: 10, unit: 'px' }
    const parseValue = (val) => {
        if (value === undefined || value === null || value === '') {
            return { num: 0, unit: 'px' };
        }

        // Handle numeric values (legacy stuff)
        if (typeof val === 'number') {
            return { num: val, unit: 'px' };
        }

        const match = String(val).match(/^([\d.-]+)(.*)$/);
        if (match) {
            return { num: parseFloat(match[1]), unit: match[2] || 'px' };
        }
        return { num: 0, unit: 'px' };
    };

    const { num, unit } = parseValue(value);

    // Internal state to handle smooth sliding before commit, if needed.
    // But for now direct control is usually fine in Gutenberg.

    const units = [
        { label: 'px', value: 'px' },
        { label: 'em', value: 'em' },
        { label: 'rem', value: 'rem' },
        { label: '%', value: '%' },
        { label: 'vw', value: 'vw' },
    ];

    const updateValue = (newNum, newUnit) => {
        // Concatenate number and unit
        onChange(`${newNum}${newUnit}`);
    };

    return (
        <div className="rtmega-custom-range-control components-base-control">
            <div className="rtmega-range-header" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '8px' }}>
                <label className="components-base-control__label">{label}</label>
                <div className="rtmega-unit-select" style={{ maxWidth: '80px' }}>
                    <SelectControl
                        value={unit}
                        options={units}
                        onChange={(newUnit) => updateValue(num, newUnit)}
                        className="rtmega-unit-select-control"
                        style={{
                            fontSize: '11px',
                            height: '30px',
                            minHeight: '30px',
                            margin: 0
                        }}
                    />
                </div>
            </div>
            <RangeControl
                value={num}
                onChange={(newNum) => updateValue(newNum, unit)}
                min={min}
                max={max}
                withInputField={true}
                showTooltip={false}
                allowReset
            />
        </div>
    );
}
