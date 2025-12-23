import { Layout } from 'antd';
import DashBoard from "@/components/DashBoard";
import '@/styles/GlobalStyle.scss'
function App() {
  return (
      <div className="App">
            <Layout>
              <DashBoard />
            </Layout>
      </div>
  );
}
export default App;