import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

function AlertToast() {  
  return (
     <ToastContainer
        position="top-right"
        autoClose={5000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        pauseOnHover
        draggable
        theme="colored"
      />
  );
}

export default AlertToast;