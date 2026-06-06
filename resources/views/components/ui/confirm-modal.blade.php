<div x-data="{
    show: false,
    title: '',
    message: '',
    actionType: 'danger',
    isAlert: false,
    onConfirm: null,
    
    init() {
        window.addEventListener('open-confirm', (e) => {
            this.title = e.detail.title || 'Konfirmasi';
            this.message = e.detail.message || 'Apakah Anda yakin?';
            this.actionType = e.detail.type || 'danger';
            this.isAlert = e.detail.isAlert || false;
            this.onConfirm = e.detail.onConfirm;
            this.show = true;
        });
    },

    confirm() {
        this.show = false;
        if (typeof this.onConfirm === 'function') {
            this.onConfirm();
        }
    }
}"
x-show="show"
class="fixed inset-0 z-50 flex items-center justify-center"
style="display: none;"
>
    <!-- Backdrop -->
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="show = false"></div>

    <!-- Modal Panel -->
    <div x-show="show" x-transition class="relative bg-white dark:bg-neutral-surface border border-neutral-border shadow-xl rounded-2xl w-full min-w-[300px] sm:min-w-[384px] max-w-sm p-6 z-10 m-4">
        <h3 class="text-lg font-heading text-neutral-text" x-text="title"></h3>
        <p class="mt-2 text-sm text-neutral-text-muted" x-text="message"></p>

        <div class="mt-6 flex justify-end gap-3">
            <button x-show="!isAlert" @click="show = false" class="px-4 py-2 text-sm font-medium text-neutral-text hover:bg-neutral-bg rounded-lg transition-colors cursor-pointer border border-transparent">
                Batal
            </button>
            <button @click="confirm()" 
                :class="{
                    'bg-error text-white hover:bg-error/90': actionType === 'danger',
                    'bg-black text-white dark:bg-white dark:text-black hover:opacity-90': actionType === 'primary',
                    'bg-success text-white hover:bg-success/90': actionType === 'success'
                }"
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors cursor-pointer"
                x-text="isAlert ? 'Tutup' : 'Ya, Lanjutkan'"
            >
            </button>
        </div>
    </div>
</div>
