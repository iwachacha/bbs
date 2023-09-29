export const options = {
  position: "top-right",
  timeout: 3000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 1,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: "button",
  icon: true,
  rtl: false,
  maxToasts: 1,
  newestOnTop: true,

  filterBeforeCreate: (toast, toasts) => {
    if (toasts.filter(
      t => t.type === toast.type
    ).length !== 0) {
      return false;
    }
    return toast;
  }
};