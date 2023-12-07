import axios from "axios";
import { useState } from "react";

const LogIn = () => {
  const [formData, setFormData] = useState({
    username: "",
    password: "",
  });
  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleLogin = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post("http://localhost/commerce_app/backend/api/users/signin_user.php", formData);

      if (response.data.status == "success") {
        localStorage.setItem("jwtToken", response.data.jwt);
        console.log("logged in");
      }
    } catch (error) {
      console.error("Error during form submission:", error);
    }
  };

  return (
    <div className="container d-flex d-center d-direction">
      <form onSubmit={handleLogin} className="form-container">
        <label htmlFor="text">UserName:</label>
        <input type="text" id="username" name="username" onChange={handleChange} required />

        <label htmlFor="password">Password:</label>
        <input type="password" id="password" name="password" onChange={handleChange} required />

        <button type="submit">Login</button>
        <p className="d-flex d-start">
          Dont have an account?
          <a href="/" className="signup-link">
            Sign up
          </a>
        </p>
      </form>
    </div>
  );
};

export default LogIn;
