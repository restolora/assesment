import React,{ useState, useEffect } from 'react';
import Wrapper from './wrapper';
import styles from '../styles/signup.module.css';

const Success = () => {
	return (
		<Wrapper>
			<div className={styles.form}>
				<h1>Registration Success!</h1>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
			</div>
		</Wrapper>
	);
};

export default Success;
