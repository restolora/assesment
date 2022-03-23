import React from 'react';
import '../styles/App.css';
import { Layout, Menu, PageHeader, Button, Row, Col } from 'antd';
const { Header, Content, Footer } = Layout;

function wrapper({ children }) {
	return (
		<>
			<Layout>
				<Header style={{ position: 'fixed', zIndex: 1, width: '100%', padding: '0', background: '#fff' }}>
					<div style={{ display: 'flex', justifyContent: 'space-between' }}>
						<div style={{ width: '10vw' }}>
							<img src={'/Logo.JPG'} style={{ width: '100px', objectFit: 'contain' }} />
						</div>
						<div
							style={{
								width: '60vw',
								display: 'flex',
								justifyContent: 'flex-end',
								alignItems: 'center',
								padding: '0 20px'
							}}>
							<Menu
								theme="light"
								mode="horizontal"
								defaultSelectedKeys={['Home']}
								style={{ width: '60%' }}>
								<Menu.Item key={'Home'}>Home</Menu.Item>
								<Menu.Item key={'About'}>About</Menu.Item>
								<Menu.Item key={'Pricing'}>Pricing</Menu.Item>
								<Menu.Item key={'Blogo'}>Blogo</Menu.Item>
								<Menu.Item key={'Page'}>Page</Menu.Item>
								<Menu.Item key={'Help'}>Help</Menu.Item>
							</Menu>
							<Button className="btn">Sign Up</Button>
						</div>
					</div>
				</Header>
				<Content style={{ padding: '0', marginTop: 64 }}>
					<div style={{ padding: 24, minHeight: '90vh', backgroundImage: 'url("./Background.jpg")' }}>
						{children}
					</div>
				</Content>
			</Layout>
		</>
	);
}

export default wrapper;
