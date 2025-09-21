import { BrowserRouter as Router } from "react-router-dom";

import PublicRoutes from "./routes/PublicRoutes";
import Layout from "./Layout/Layout";

import AlertToast from "./components/alerts/AlertToast";

function App() {
  return (
    <Router>
      <AlertToast />
      <Layout>
        <PublicRoutes />
      </Layout>
    </Router>
  );
}

export default App;
