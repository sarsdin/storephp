import Home from '../components/Home.vue'
import menu from '../components/Menu.vue'
import header from '../components/Header.vue'
import notice from '../components/Notice.vue'
import noticeContent from '../components/NoticeContent.vue'
import notice2 from '../components/Notice2.vue'
import noticeCU from '../components/NoticeCU.vue'
import login from "../components/Login.vue";
import join from "../components/Join.vue";
import contentholder from "../components/Contentholder.vue";
import addproduct from "../components/AddProduct.vue";
import productDetail from "../components/ProductDetail.vue";
import cart from "../components/Cart.vue";
import payment from "../components/Payment.vue";
import paymentComplete from "../components/PaymentComplete.vue";
import tos from "../components/Tos.vue";
import orderCheck from "../components/OrderCheck.vue";
import orderCheckDetail from "../components/OrderCheckDetail.vue";
import orderAdmin from "../components/OrderAdmin.vue";


const routes = [
    {
        path: '/',
        component: Home,        // default <router-view> - name속성이 없으면 자동으로 default로 지정됨.
        name: 'home',
        // redirect:{name : 'contentholder'},
        children: [{
                path:'',
                components: { home : contentholder }, 
                // notice라는 이름의 <router-view>를 컴포넌트로 가진다. 그리고, 거기에 import된 contentholder라는 vue를 보여준다.
                name:'contentholder'
            },
            {
                path: 'menu',
                components: { home : menu },
                name: 'menu',
                props:true
            },
            {
                path:'notice',
                components: { home : notice },
                name:'notice',
                children: [
                    {
                        // path:'noticeContent/:no/content/:content', //이동할 때 그 row의 글번호 데이터를 파라미터로 받아서 noticeContent에서 $router.params.no 로 사용가능!
                        path:'noticeContent',
                        components: { noticeContent : noticeContent },
                        name:'noticeContent',
                        props:true  
                        //params로 데이터를 넘길때는 props를 true로 두면 컴포넌트에 데이터가 props로도 전달된다.
                        //path의 /:tmp 이런 :파라미터로 넘어온 값만 해당. 그럼 해당 컴포넌트에서 props: ['tmp'] 형태로 로드가능.
                    }
                ],
            },
            {
                path:'addproduct',
                components: { home : addproduct },
                name: 'addproduct'
            },
            {
                path: 'noticeCU',
                name: 'noticeCU',
                components:{
                    // default: ()=> import('../components/Header.vue'),
                    home : noticeCU
                },
                // props:true
            },
            {
                path: 'productDetail',
                name: 'productDetail',
                components: { home: productDetail }
            },
            {
                path: 'cart',
                name: 'cart',
                components: { home: cart }
            },
            {
                path: 'payment',
                name: 'payment',
                components: { home: payment }
            },
            {
                path: 'paymentComplete',
                name: 'paymentComplete',
                components: { home: paymentComplete }
            },
            {
                path: 'orderCheck',
                name: 'orderCheck',
                components: { home: orderCheck }
            },
            {
                path: 'orderCheckDetail',
                name: 'orderCheckDetail',
                components: { home: orderCheckDetail }
            },
            {
                path: 'orderAdmin',
                name: 'orderAdmin',
                components: { home: orderAdmin }
            },


            
        ],
        props:true
    },
 
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
    },
    {
        path: '/tos',
        name: 'tos',
        components: {
            default: tos
        }
    }
]


export default routes
