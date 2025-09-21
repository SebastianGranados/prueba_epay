import React from "react";

interface InputProps extends React.InputHTMLAttributes<HTMLInputElement> {
  label: string;
  value: string;
  name: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
}

const Input: React.FC<InputProps> = ({ label, value, name, onChange, ...rest }) => {
  return (
    <div>
      <label className="block text-sm font-medium text-gray-700">{label}</label>
      <input
        name={name}
        value={value}
        onChange={onChange}
        className="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50"
        {...rest}
      />
    </div>
  );
};

export default Input;