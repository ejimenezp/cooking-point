import React from 'react'
import { Outlet, Link } from 'react-router-dom'

import Container from 'react-bootstrap/Container'
import Row from 'react-bootstrap/Row'
import Col from 'react-bootstrap/Col'
import Dropdown from 'react-bootstrap/Dropdown'
import './Layout.scss'

const Layout = () => {

  const userName = document.querySelector('meta[name="user_name"]').content
  const userRole = document.querySelector('meta[name="user_role"]').content

  return (

    <>
      {/* smartphones, tablets */}

      <div className="d-block d-md-none">
        <Dropdown bsPrefix="cp-smartphone-navbar d-flex flex-column align-items-start">
          <Dropdown.Toggle as="img" bsPrefix="menu-strips" src="/images/icons/menu-strips.png" />
          <Dropdown.Menu as="ul">
            <Dropdown.Item as="li"><a href="/admin/bookings">Bookings</a></Dropdown.Item>
            {userRole > 1 && <Dropdown.Item as="li"><a href="/admin/report">Reports</a></Dropdown.Item>}
            {userRole > 1 && <Dropdown.Item as="li"><Link to="shop">Tienda</Link></Dropdown.Item>}
            {userRole > 1 && <Dropdown.Item as="li"><Link to="wallet">Caja</Link></Dropdown.Item>}
            {userRole > 2 && <Dropdown.Item as="li"><a href="/admin/blogtool">Blog</a></Dropdown.Item>}
            <Dropdown.Item as="li"><a href="/admin/logout">Salir</a></Dropdown.Item>
            <Dropdown.ItemText as="li">{userName}</Dropdown.ItemText>
          </Dropdown.Menu>
        </Dropdown>
      </div>
      <div className="navbar-offset"></div>

      {/* desktops */}

      <div className="d-none d-md-block">
        <div className="cp-navbar">
          <div className="menu clearfix">
            <ul>
              <li><a href="/admin/bookings">Bookings</a></li>
              {userRole > 1 && <li><a href="/admin/report">Reports</a></li>}
              {userRole > 1 && <li><Link to="shop">Tienda</Link></li>}
              {userRole > 1 && <li><Link to="wallet">Caja</Link></li>}
              {userRole > 2 && <li><a href="/admin/blogtool">Blog</a></li>}
              <li><a href="/admin/logout">Salir</a></li>
              <li><a href="/admin" style={{ color: 'black' }}>{userName}</a></li>
            </ul>
          </div>
        </div>
      </div>

      {/* Contents */}

      <Container fluid>
        <div className="divider"></div>
        <Row noGutters className="justify-content-center">
          <Col xl={10}>
            <Outlet />
          </Col>
        </Row>
      </Container>

    </>
  )
}

export default Layout
