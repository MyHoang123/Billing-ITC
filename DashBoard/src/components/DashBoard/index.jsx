import { useEffect, useRef, useState } from 'react';
import {
    AppstoreOutlined,
    FallOutlined,
    BookOutlined,
    DollarOutlined,
    RiseOutlined,
} from '@ant-design/icons';
import { getTotalDay } from './Sevice'
import { Space, Layout, Select, theme, Row, Col, Statistic } from 'antd';
import DataTable from './DataTable';
const { Header, Sider, Content } = Layout;
import { Chart, registerables } from 'chart.js';
import CountUp from 'react-countup';
import classNames from "classnames/bind";
import styles from "./Dashboard.module.scss";
const cx = classNames.bind(styles);
Chart.register(...registerables);
const formatter = value => <CountUp end={value} separator="," />;
const formatterVnd = (value) => (
  <CountUp
    end={Number(value)}
    separator="."
    suffix=" ₫"
    duration={1.2}
  />
);
function DashBoardComponent() {
    const [TotalDay, setTotalDay] = useState({ OrderPaidYesterday: 0, RefundedYesterday: 0, TotalAmountYesterday: 0, TotalRefundYesterday: 0, Cancel: 0 })
    const [Data, setData] = useState([])
    const [RevenueYTD, setRevenueYTD] = useState([])
    const canvasLine = useRef()
    const canvasPie = useRef()
    const {
        token: { borderRadiusLG },
    } = theme.useToken();
    useEffect(() => {
        let myCanvasLine
        let myCanvasDoughnut
        const context = canvasLine.current.getContext('2d');
        var gradient = context.createLinearGradient(212, 248, 243, 1);
        gradient.addColorStop(1, "rgba(109, 157, 236, 1)");
        gradient.addColorStop(0, "rgba(5, 100, 233, 0)");
        myCanvasLine = new Chart(canvasLine.current, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#0f04d6',
                    tension: 0.4,
                    data: RevenueYTD,
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,

                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },

                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        intersect: false
                    }
                },

                interaction: {
                    intersect: false
                },

                scales: {
                    x: {
                        grid: {
                            borderDash: [4, 4]
                        }
                    },
                    y: {
                        grid: {
                            borderDash: [4, 4]
                        }
                    }
                }
            }
        });
        myCanvasDoughnut = new Chart(canvasPie.current, {
            type: "doughnut",
            data: {
                labels: ["Thanh toán", "Hoàn trả", "Hủy"],
                datasets: [{
                    data: [TotalDay.OrderPaidYesterday, TotalDay.RefundedYesterday, TotalDay.Cancel],
                    backgroundColor: [
                        '#41ffa3ff',
                        '#0f04d6',
                        '#eb2d4b'
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });
        return () => {
                myCanvasLine.destroy()
                myCanvasDoughnut.destroy()
        }
    }, [RevenueYTD])
    useEffect(() => {
        getTotalDay().then((response) => {
            if (response.data.status) {
                setTotalDay(response.data.data.DataDay)
                setData(response.data.data.Record)
                setRevenueYTD(response.data.data.RevenueYTD)
            }
        }).catch((err) => {
            console.log(err)
        })
    }, [])
    return (
        <Content
            style={{
                margin: '20px',
                borderRadius: borderRadiusLG,
            }}
        >
            <Row gutter={{ xs: 8, sm: 16, md: 20, lg: 20 }}>
                <Col xs={24} sm={12} md={12} lg={12} xl={6}>
                    <div className={cx('Dashboard_header_item')}>
                        <Space className={cx('Dashboard_header_item-title')}>
                            <span>Đã thanh toán</span>
                            <div className={cx('Dashboard_header_item-title--icon')}><AppstoreOutlined /></div>
                        </Space>
                        <Space className={cx('Dashboard_header_item-content')}>
                            <Statistic valueStyle={{ color: '#0f04d6', fontSize: '24px', fontWeight: '600' }} formatter={formatter} value={TotalDay.OrderPaidYesterday} ></Statistic>
                            <Statistic
                                value={11.28}
                                precision={2}
                                valueStyle={{ color: '#3f8600', fontSize: '14px' }}
                                prefix={<RiseOutlined />}
                                suffix="%"
                            />
                        </Space>
                        <Space className={cx('Dashboard_header_item-footer')}>
                            <span>Since Last Day</span>
                        </Space>
                    </div>
                </Col>
                <Col xs={24} sm={12} md={12} lg={12} xl={6}>
                    <div className={cx('Dashboard_header_item')}>
                        <Space className={cx('Dashboard_header_item-title')}>
                            <span>Đã hoàn trả </span>
                            <div className={cx('Dashboard_header_item-title--icon')}><BookOutlined /></div>
                        </Space>
                        <Space className={cx('Dashboard_header_item-content')}>
                            <Statistic valueStyle={{ color: '#0f04d6', fontSize: '24px', fontWeight: '600' }} formatter={formatter} value={TotalDay.RefundedYesterday} ></Statistic>
                            <Statistic
                                value={11.28}
                                precision={2}
                                valueStyle={{ color: '#3f8600', fontSize: '14px' }}
                                prefix={<RiseOutlined />}
                                suffix="%"
                            />
                        </Space>
                        <Space className={cx('Dashboard_header_item-footer')}>
                            <span>Since Last Day</span>
                        </Space>
                    </div>
                </Col>
                <Col xs={24} sm={12} md={12} lg={12} xl={6}>
                    <div className={cx('Dashboard_header_item')}>
                        <Space className={cx('Dashboard_header_item-title')}>
                            <span>Tổng tiền hoàn trả</span>
                            <div className={cx('Dashboard_header_item-title--icon')}><AppstoreOutlined /></div>
                        </Space>
                        <Space className={cx('Dashboard_header_item-content')}>
                            <Statistic valueStyle={{ color: '#0f04d6', fontSize: '24px', fontWeight: '600' }} formatter={formatterVnd} value={TotalDay.TotalRefundYesterday} ></Statistic>
                            <Statistic
                                value={11.28}
                                precision={2}
                                valueStyle={{ color: '#cf1322', fontSize: '18px' }}
                                prefix={<FallOutlined />}
                                suffix="%"
                            />
                        </Space>
                        <Space className={cx('Dashboard_header_item-footer')}>
                            <span>Since Last Day</span>
                        </Space>
                    </div>
                </Col>
                <Col xs={24} sm={12} md={12} lg={12} xl={6}>
                    <div className={cx('Dashboard_header_item')}>
                        <Space className={cx('Dashboard_header_item-title')}>
                            <span>Tổng tiền nhận</span>
                            <div className={cx('Dashboard_header_item-title--icon')}><DollarOutlined /></div>
                        </Space>
                        <Space className={cx('Dashboard_header_item-content')}>
                            <Statistic valueStyle={{ color: '#0f04d6', fontSize: '24px', fontWeight: '600' }} formatter={formatterVnd} value={TotalDay.TotalAmountYesterday} ></Statistic>
                            <Statistic
                                value={11.28}
                                precision={2}
                                valueStyle={{ color: '#3f8600', fontSize: '14px' }}
                                prefix={<RiseOutlined />}
                                suffix="%"
                            />
                        </Space>
                        <Space className={cx('Dashboard_header_item-footer')}>
                            <span>Since Last Day</span>
                        </Space>
                    </div>
                </Col>
            </Row>
            <Row gutter={{ xs: 8, sm: 16, md: 20, lg: 20 }}>
                <Col xs={24} sm={24} md={24} lg={18} xl={18}>
                    <div className={cx('Dashboard_body_item-statis')}>
                            <canvas ref={canvasLine} width={1400} height={360} id="chartjs-dashboard-line"></canvas>
                    </div>
                </Col>
                <Col xs={24} sm={24} md={24} lg={6} xl={6}>
                    <div className={cx('Dashboard_body_item-statis')}>
                        <canvas ref={canvasPie} width={360} height={360} id="chartjs-dashboard-pie"></canvas>
                    </div>
                </Col>
            </Row>
            <Row gutter={{ xs: 8, sm: 16, md: 20, lg: 20 }}>
                <Col xs={24} sm={24} md={24} lg={24} xl={24}>
                    <div className={cx('Data_Table_Container')}>
                        <DataTable Data={Data} />
                    </div>
                </Col>
            </Row>
        </Content>
    );
}

export default DashBoardComponent;