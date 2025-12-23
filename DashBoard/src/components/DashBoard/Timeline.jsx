import React, { useEffect, useState } from 'react';
import { Modal, Timeline } from 'antd';
import { getHistory } from './Sevice'
import classNames from "classnames/bind";
import styles from "./Dashboard.module.scss";
const cx = classNames.bind(styles);
const App = ({ isModalOpen, setIsModalOpen }) => {
    const [content, setContent] = useState([])
    const handleOk = () => {
        setIsModalOpen({IsOpen: false, Book: null, Id: null});
        setContent([])
    };
    const handleCancel = () => {
        setIsModalOpen({IsOpen: false, Book: null, Id: null});
        setContent([])
    };
    useEffect(() => {
        if (isModalOpen.Id) {
            getHistory(isModalOpen.Id).then((response) => {
                if (response.data.status) {
                    setContent(response.data.data)
                }
            }).catch((err) => {
                console.log(err)
            })
        }
    }, [isModalOpen])
    return (
        <Modal
            title="Lịch sử giao dịch"
            closable={{ 'aria-label': 'Custom Close Button' }}
            open={isModalOpen.IsOpen}
            centered
            onOk={handleOk}
            onCancel={handleCancel}
        >
            <h5>
                ID: {isModalOpen.Book}
            </h5>
            <div className={cx('Modal_Timeline')}>
                <Timeline>
                    {content.map((val, i) => (
                        <Timeline.Item key={i} color={val.api_endpoint === 'pg-paygate-create-order' ? 'blue' : val.api_endpoint === 'pg-paygate-check-status' ? 'blue' : val.api_endpoint === 'green' ? 'Thanh toán giao dịch' : 'cyan'} >
                            <div style={{ fontWeight: 500 }}>{val.created_at}</div>
                            <span style={{ color: '#000' }}>
                                {val.api_endpoint === 'pg-paygate-create-order' ? 'Khởi tạo giao dịch' : val.api_endpoint === 'pg-paygate-check-status' ? 'Kiểm tra giao dịch' : val.api_endpoint === 'pg-paygate-ipn' ? 'Thanh toán giao dịch' : 'Hoàn trả giao dịch'}
                            </span>
                        </Timeline.Item>

                    ))}
                </Timeline>
            </div>
        </Modal>
    );
};
export default App;