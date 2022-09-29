import { useField } from 'formik';
import { useQuery } from "react-query";
import myFetch from "./myFetch";

const MySelect = ({ label, ...props }) => {
  const [field, meta] = useField(props);

  // const { isLoading, error, data } = useQuery("source", () =>
  //   myFetch('/api/source/get'),
  //       {staleTime: Infinity}
  // );

  return (
    <div>
      <label htmlFor={props.id || props.name}>{label}</label>
      <select {...field} {...props}>
        {/*{ data.map(source => <option key={source.id} value={source.id}>{source.name}</option>) }*/}
      </select>
      {meta.touched && meta.error ? (
        <div className="error">{meta.error}</div>
      ) : null}
    </div>
  );
};

export default MySelect;
