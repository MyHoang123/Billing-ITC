import { useState, memo } from "react";
import {
    CheckOutlined,
    EyeOutlined,
    DeleteOutlined,
} from '@ant-design/icons';
import classNames from "classnames/bind";
import ModalTimeline from './Timeline'
import styles from "./Dashboard.module.scss";
import { DatePicker, Layout, Select, theme, ConfigProvider, Tag, Table, Space, Button } from 'antd';

const { Header, Sider, Content } = Layout;
const cx = classNames.bind(styles);

function DataTable({ Data }) {
    const {
        token: { borderRadiusLG },
    } = theme.useToken();
    const [isModalOpen, setIsModalOpen] = useState({IsOpen: false, Book: null, Id: null});

    const columns = [
        {
            title: 'Mã đơn hàng',
            dataIndex: 'booking_no',
            width: 120,
            align: 'center',
            key: 'id',
            // sorter: (a, b) => a.name.length - b.name.length,
            ellipsis: true,
        },
        {
            title: 'Tổng tiền nhận',
            dataIndex: 'amount',
            align: 'center',
            key: 'id',
            width: 135,
            // sorter: (a, b) => a.age - b.age,
            ellipsis: true,
        },
        {
            title: 'Tổng tiền hoàn',
            dataIndex: 'refund_amount',
            key: 'id',
            align: 'center',
            width: 150,
            // sorter: (a, b) => a.address.length - b.address.length,
            ellipsis: true,
        },
        {
            title: 'FT Code',
            dataIndex: 'pg_issuer_txn_reference',
            align: 'center',
            key: 'id',
            width: 150,
            // sorter: (a, b) => a.address.length - b.address.length,
            ellipsis: true,
        },
        {
            title: 'Thời gian',
            dataIndex: 'pg_paytime',
            align: 'center',
            key: 'id',
            // sorter: (a, b) => a.age - b.age,
            ellipsis: true,
            render: (value) => {
                if (!value) return '';
                return `${value.slice(6, 8)}/${value.slice(4, 6)}/${value.slice(0, 4)} 
                ${value.slice(8, 10)}:${value.slice(10, 12)}:${value.slice(12, 14)}`;
            }
        },
        {
            title: 'Nội dung',
            dataIndex: 'pg_order_info',
            align: 'center',
            key: 'id',
            // sorter: (a, b) => a.age - b.age,
            ellipsis: true,
        },
        {
            title: 'Số thẻ',
            dataIndex: 'pg_card_number',
            align: 'center',
            key: 'id',
            // sorter: (a, b) => a.age - b.age,
            ellipsis: true,
        },
        {
            title: 'Tên chủ thẻ',
            dataIndex: 'pg_card_holder_name',
            align: 'center',
            key: 'id',
            // sorter: (a, b) => a.age - b.age,
            ellipsis: true,
        },
        {
            title: 'Trạng thái',
            dataIndex: 'status',
            align: 'center',
            key: 'id',
            width: 125,
            // sorter: (a, b) => a.address.length - b.address.length,
            ellipsis: true,
            render: (_, { Status }) => (
                <>
                    {
                        Status === 'PENDING' ? (
                            <Tag style={{ width: '70px', textAlign: 'center' }} color="gold">PENDING</Tag>
                        ) : Status === 'CANCELLED' ? (
                            <Tag style={{ width: '70px', textAlign: 'center' }} color="magenta">CANCELLED</Tag>
                        ) :
                            (
                                <Tag style={{ width: '70px', textAlign: 'center' }} color="cyan">PAID</Tag>
                            )
                    }
                </>
            ),
        },
        {
            title: 'Thao tác',
            key: 'id',
            align: 'center',
            width: 120,
            // sorter: (a, b) => a.address.length - b.address.length,
            ellipsis: true,
            render: (record) => (
                <Space>
                    <ConfigProvider
                        theme={{
                            components: {
                                Button: {
                                    defaultBg: '#e6f8f4',
                                    defaultColor: '#569486',
                                    defaultHoverBg: '#039a89',
                                    defaultHoverColor: '#fff'
                                },
                            },
                        }}
                    >
                        <Button onClick={() => setIsModalOpen({Book: record.booking_no, Id: record.transaction_ref_id, IsOpen: true})} style={{ border: 'none' }} icon={<EyeOutlined />} />
                    </ConfigProvider>
                </Space>
            ),
        },
    ];
    return (
        <Content
            style={{
                borderRadius: borderRadiusLG,
            }}
        >
            <div className={cx('Dashboard_container')}>
                <div className={cx('Dashboard_container_header')}>
                    <span className={cx('Dashboard_container_header-title')}>Tổng hợp</span>
                    <div className={cx('Dashboard_container_header-filter')}>
                        <Select
                            className="my-custom-select"
                            placeholder="Day"
                            optionFilterProp="label"
                            // onChange={onChange}
                            // onSearch={onSearch}
                            options={[
                                {
                                    value: 'Day',
                                    label: 'Day',
                                },
                                {
                                    value: 'Month',
                                    label: 'Month',
                                },
                                {
                                    value: 'Year',
                                    label: 'Year',
                                },
                            ]}
                        />
                    </div>
                </div>
                <div className={cx('Order_container_table')}>
                    <Table rowKey="id" className='Header_table' columns={columns} dataSource={Data} pagination={false} scroll={{ x: 'max-content' }} />
                </div>
                <div className={cx('Order_container_page')}>
                    <ConfigProvider
                        theme={{
                            components: {
                                Pagination: {
                                    colorBgContainer: '#fff',         // màu nền của nút
                                    colorPrimary: '#eb3c4e',          // màu chính (active)
                                    borderRadius: 6,                  // bo góc cho các nút
                                    colorPrimaryHover: '#eb3c4e',     // màu hover active
                                },
                            },
                        }}
                    >
                    </ConfigProvider>
                </div>
            </div>
            {/* TimeLine */}
            <ModalTimeline isModalOpen = {isModalOpen} setIsModalOpen = {setIsModalOpen} />
        </Content>
    );
}

export default memo(DataTable);