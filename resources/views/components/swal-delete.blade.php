@props(['selector' => null])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('submit', function(e) {
            if (e.target.matches(@json($selector))) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data akan hilang secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    background: '#0f0f0f',
                    color: '#f9fafb',
                    customClass: {
                        popup: 'custom-swal-popup',
                        confirmButton: 'custom-confirm-btn',
                        cancelButton: 'custom-cancel-btn',
                        icon: 'custom-icon'
                    },
                    didOpen: () => {
                        // Add custom styles
                        const style = document.createElement('style');
                        style.textContent = `
                            .custom-swal-popup {
                                background: #0f0f0f !important;
                                border: 1px solid #333 !important;
                                border-radius: 16px !important;
                                box-shadow: 
                                    0 4px 20px rgba(0, 0, 0, 0.3),
                                    0 0 0 1px rgba(255, 255, 255, 0.1) !important;
                                transition: all 0.3s ease !important;
                            }
                            
                            .custom-swal-popup:hover {
                                box-shadow: 
                                    0 8px 40px rgba(255, 255, 255, 0.3),
                                    0 0 0 1px rgba(255, 255, 255, 0.4),
                                    0 0 30px rgba(255, 255, 255, 0.2) !important;
                                transform: translateY(-2px) !important;
                            }
                            
                            .custom-confirm-btn {
                                background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
                                border: none !important;
                                border-radius: 10px !important;
                                padding: 12px 24px !important;
                                font-weight: 600 !important;
                                transition: all 0.3s ease !important;
                                box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3) !important;
                            }
                            
                            .custom-confirm-btn:hover {
                                background: linear-gradient(135deg, #ef4444, #dc2626) !important;
                                box-shadow: 
                                    0 6px 25px rgba(220, 38, 38, 0.4),
                                    0 0 20px rgba(220, 38, 38, 0.5) !important;
                                transform: translateY(-2px) !important;
                            }
                            
                            .custom-cancel-btn {
                                background: linear-gradient(135deg, #e5e7eb, #d1d5db) !important;
                                color: #1f2937 !important;
                                border: none !important;
                                border-radius: 10px !important;
                                padding: 12px 24px !important;
                                font-weight: 600 !important;
                                transition: all 0.3s ease !important;
                                box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3) !important;
                            }
                            
                            .custom-cancel-btn:hover {
                                background: linear-gradient(135deg, #f3f4f6, #e5e7eb) !important;
                                color: #111827 !important;
                                box-shadow: 
                                    0 6px 25px rgba(255, 255, 255, 0.4),
                                    0 0 20px rgba(255, 255, 255, 0.5) !important;
                                transform: translateY(-2px) !important;
                            }
                            
                            .custom-icon {
                                border-color: #f59e0b !important;
                                color: #f59e0b !important;
                                filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.3)) !important;
                            }
                            
                            .swal2-title {
                                color: #f9fafb !important;
                                font-weight: 700 !important;
                                text-shadow: 0 0 10px rgba(249, 250, 251, 0.3) !important;
                            }
                            
                            .swal2-html-container {
                                color: #d1d5db !important;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            }
        });
    });
</script>
