import { useState, type ReactNode } from "react";
import { Link, Outlet } from "react-router-dom";

interface LayoutProps {
  children?: ReactNode;
}

const Layout = ({ children }: LayoutProps) => {
  const [mobileOpen, setMobileOpen] = useState(false);

  return (
    <div className="mx-auto p-2 bg-gray-200 text-gray-900 rounded-2xl">
      <header className="bg-gray-50 shadow-sm sticky top-0 z-10">
        <div className="max-w-6xl mx-auto px-10 py-4 flex items-center justify-between">
          <Link to="/wallet" className="text-xl font-semibold text-indigo-600">
            MyPay App
          </Link>

          <nav className="hidden md:flex items-center gap-6">
            <Link
              to="/wallet"
              className="text-sm font-medium text-gray-700 hover:text-indigo-600"
            >
              Billetera
            </Link>
            <Link
              to="/payment"
              className="text-sm font-medium text-gray-700 hover:text-indigo-600"
            >
              Solicitar pagos
            </Link>
            <Link
              to="/customer"
              className="text-sm font-medium text-gray-700 hover:text-indigo-600"
            >
              Registrate
            </Link>
          </nav>

          <button
            type="button"
            className="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-controls="mobile-menu"
            aria-expanded={mobileOpen}
            onClick={() => setMobileOpen((v) => !v)}
          >
            <span className="sr-only">Abrir menú</span>
            {mobileOpen ? (
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                className="h-6 w-6"
              >
                <path
                  fillRule="evenodd"
                  d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                  clipRule="evenodd"
                />
              </svg>
            ) : (
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth={1.5}
                stroke="currentColor"
                className="h-6 w-6"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
              </svg>
            )}
          </button>
        </div>

        {mobileOpen && (
          <div id="mobile-menu" className="md:hidden bg-gray-50">
            <div className="space-y-1 px-4 py-3">
              <Link
                to="/wallet"
                className="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-200 hover:text-indigo-600"
                onClick={() => setMobileOpen(false)}
              >
                Billetera
              </Link>
              <Link
                to="/payment"
                className="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-200 hover:text-indigo-600"
                onClick={() => setMobileOpen(false)}
              >
                Solicitar pagos
              </Link>
              <Link
                to="/customer"
                className="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-200 hover:text-indigo-600"
                onClick={() => setMobileOpen(false)}
              >
                Registrate
              </Link>
            </div>
          </div>
        )}
      </header>

      <main className="max-w-6xl mx-auto px-4 py-6 h-screen">
        {children || <Outlet />}
      </main>
    </div>
  );
};

export default Layout;
