import { useToast } from 'primevue/usetoast';

export function showToast(toast, severity, summary, detail, life = 3000) {
    toast.add({
        severity: severity, // 'success', 'info', 'warn', 'error'
        summary: summary, // Title of the toast
        detail: detail, // Message inside the toast
        life: life, // Duration (milliseconds)
    });
}
