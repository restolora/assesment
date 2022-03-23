import React from 'react';
import Wrapper from './wrapper';
import styles from '../styles/signup.module.css';
import { Form, Input, Button, Row, Col } from 'antd';
import { useFormik } from 'formik';
import * as yup from 'yup';

const Signup = () => {
	const validationSchema = yup.object({
		Name: yup.string().required('Name is a required field'),
		Email: yup.string().email('Invalid Email Address').required('Email is a required field'),
		Password: yup
			.string()
			.required('Password is a required field')
			.min(8, 'Password is too short - should be 8 chars minimum.')
			.max(16, 'Password is too long - should be 16 chars minimum.')
			.matches(
				/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,
				'Password must have atleast 1 special character'
			)
	});
	const initialValues = {
		Name: '',
		Email: '',
		Password: ''
	};
	const onSubmit = values => {
		alert(JSON.stringify(values, null, 2));
	};
	const formik = useFormik({ initialValues, validationSchema, onSubmit });

	return (
		<Wrapper>
			<div className={styles.form}>
				<h1>Start your free trial</h1>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
				<Form onFinish={formik.handleSubmit} layout={'vertical'} style={{ width: '600px', margin: '0 auto' }}>
					<Row gutter={[0, 0]}>
						<Col span={24}>
							<Form.Item
								key="Name"
								label="Name"
								hasFeedback={formik.touched.Name && true}
								validateStatus={formik.errors && formik.errors.Name ? 'error' : 'success'}
								help={formik.errors.Name && formik.touched.Name ? <p>{formik.errors.Name}</p> : ''}>
								<Input
									id="name"
									name="Name"
									onChange={formik.handleChange}
									className={styles.input}
									value={formik.values.Name}
								/>
							</Form.Item>
						</Col>
						<Col span={24}>
							<Form.Item
								key="Email"
								label="Email"
								hasFeedback={formik.touched.Email && true}
								validateStatus={formik.errors && formik.errors.Email ? 'error' : 'success'}
								help={formik.errors.Email && formik.touched.Email ? <p>{formik.errors.Email}</p> : ''}>
								<Input
									id="Email"
									name="Email"
									onChange={formik.handleChange}
									className={styles.input}
									value={formik.values.Email}
								/>
							</Form.Item>
						</Col>
						<Col span={24}>
							<Form.Item
								key="Password"
								label="Password"
								hasFeedback={formik.touched.Password && true}
								validateStatus={formik.errors && formik.errors.Password ? 'error' : 'success'}
								help={
									formik.errors.Password && formik.touched.Password ? (
										<p>{formik.errors.Password}</p>
									) : (
										''
									)
								}>
								<Input
									id="Password"
									name="Password"
									onChange={formik.handleChange}
									className={styles.input}
									value={formik.values.Password}
								/>
							</Form.Item>
						</Col>
					</Row>

					<Form.Item>
						<Button htmlType="submit" className={styles.btn} type="primary">
							Submit
						</Button>
					</Form.Item>
				</Form>
			</div>
		</Wrapper>
	);
};

export default Signup;
