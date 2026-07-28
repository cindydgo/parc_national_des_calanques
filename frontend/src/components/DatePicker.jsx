import { useState, useEffect } from 'react';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';

export default function BasicDatePicker({ label }) {
    const [cleared, setCleared] = useState(false);

    useEffect(() => {
        if (cleared) {
        const timeout = setTimeout(() => {
            setCleared(false);
        }, 1500);

        return () => clearTimeout(timeout);
        }
        return () => {};
    }, [cleared]);

    return (
    <LocalizationProvider dateAdapter={AdapterDayjs}>
        <DatePicker
            label={label}
            slotProps={{
                field: { clearable: true, onClear: () => setCleared(true) }
            }}
        />
    </LocalizationProvider>
    );
}
