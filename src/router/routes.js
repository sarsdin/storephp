import Home from '../components/Home.vue'
import header from '../components/Header.vue'
import notice from '../components/Notice.vue'
import noticeContent from '../components/NoticeContent.vue'
import notice2 from '../components/Notice2.vue'
import login from "../components/Login.vue";
import join from "../components/Join.vue";
import contentholder from "../components/Contentholder.vue";
import addproduct from "../components/AddProduct.vue";


const routes = [
    {
        path: '/',
        component: Home,        // default <router-view> - name속성이 없으면 자동으로 default로 지정됨.
        name: 'home',
        redirect:{name : 'contentholder'},
        children: [{
                path:'',
                components: { notice : contentholder }, 
                // notice라는 이름의 <router-view>를 컴포넌트로 가진다. 그리고, 거기에 import된 contentholder라는 vue를 보여준다.
                name:'contentholder'
            },
            {
                path:'notice',
                components: { notice : notice },
                name:'notice'
            },
            {
                path:'addproduct',
                components: { notice : addproduct },
                name: 'addproduct'
            },
            {
                // path:'noticeContent/:no/content/:content', //이동할 때 그 row의 글번호 데이터를 파라미터로 받아서 noticeContent에서 $router.params.no 로 사용가능!
                path:'noticeContent',
                components: { notice : noticeContent },
                name:'noticeContent',
                props:true      //params로 데이터를 넘길때는 props를 true로 두면 컴포넌트에 데이터가 props로도 전달된다.
            }
        ],
        props:true
    },
    // {
    //     path: '/notice',
    //     name: 'notice',
    //     components:{
    //         default: ()=> import('../components/Header.vue'),
    //         notice
    //     }
    // },
    {
        path: '/test/test2',
        name: 'notice2',
        components:{
            default: notice2
        }
    },
    {
        path: '/login',
        name: 'login',
        components: {
            default: login
        }
    },
    {
        path: '/join',
        name: 'join',
        components: {
            default: join
        }
    }
]


export default routes
