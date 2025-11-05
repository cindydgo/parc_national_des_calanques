import { Routes, Route } from 'react-router-dom';

import Header from "./components/Header.jsx";
import Footer from "./components/Footer.jsx";

import Home from "./pages/Home.jsx";
import About from "./pages/About.jsx";
import Login from "./pages/Login.jsx";
import Register from "./pages/Register.jsx";
import Campings from "./pages/Campings.jsx";
import Sentiers from "./pages/Sentiers.jsx";
import Resources from "./pages/Resources.jsx";
import Error from "./pages/Error.jsx";

import './assets/css/App.css'

function App() {
    return (
        <>
            <Header />

            <Routes>
                <Route path='/'                         element={<Home />} />
                <Route path="/about"                    element={<About />} />
                <Route path="/login"                    element={<Login />} />
                <Route path="/register"                 element={<Register />} />
                <Route path="/campings"                 element={<Campings />} /> 
                <Route path="/sentiers"                 element={<Sentiers />} />
                <Route path="/sentiers/:sentierId"      element={<Sentiers />} />
                <Route path="/resources"                element={<Resources />} />
                <Route path="/resources/:resourceId"    element={<Resources />} />
                <Route path="*"                         element={<Error />} />
            </Routes>

            <Footer />
        </>
    )
}

export default App
