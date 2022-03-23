import React, { useState } from 'react';
import { BrowserRouter as Router,Routes, Route } from 'react-router-dom';
import './styles/App.css';
import Signup from './components/Signup';
import Success from './components/Success';

function App() {
	const [success, setSuccess] = useState(false);
 	return (
		<Router>
			<Routes>
                 <Route exact path='/' element={< Signup setSuccess={setSuccess}/>}></Route>
                 <Route exact path='/success' element={success ? < Success /> : <h1 align="center">404 - Page Not Found!</h1>}></Route>
          	</Routes>
		</Router>
	)
	
	
}

export default App;
