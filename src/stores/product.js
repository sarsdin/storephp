import { defineStore } from 'pinia'
import http from '@/modules/http'
import { useStore } from './store'

export const useProductStore = defineStore('productStore', {
    state: () => {
        return {
            paging : {
                prevPage: 0,
                nextPage: 0,
                firstPage: 0,
                lastPage: 0,
                currentPage: 1,             //초기화 필요
                totalPageCount: 0,
                itemsPerPage: 12,            //초기화 필요
                pageCountPerPageGroup: 10,  //초기화 필요
                seqOfPageGroup: 0,
                totalItems: 0,              //서버로부터 받아오는 값 
                currentItem: 0,             
                productSearch: '',
                // productSearchType: '제목'
                productCategory: '',
                categoryParent: ''          //상위 상품카테고리
            },
            classVar: 1,                    //paging에서 선택된 페이지번호 css적용(bold)에 사용되는 변수. 페이지번호와 이변수 값이 같으면 true라서 :class가 적용되는 방식
            rowClickedCSSVar: 0,            //위와 같이 선택된 글 css 변경으로 표시

            //댓글쪽 변수
            reply :{
                notice_reply_no: 0,
                notice_no: 0,
                notice_reply_writer: '',
                notice_reply_content: '',
                notice_reply_writedate: '',
                notice_reply_deletedate: '',
                parent_reply_no: 0,
                parent_reply_writer: '',
                reply_order_in_group: 0,
                reply_group: 0,
                reply_image: '',

                //답글달기 나타나게 할지말지 결정하는 변수
                // isAnswerInput: false,
            },

            replyL : [],
            currentAnswerInputItemNumber : -1,

            //홈헤더 상품 검색
            productSearchList: [],
            
            
        }
    },
    getters: {
        pagingC() {
            const res = {
                currentItem: this.paging.currentItem,                         //현재 클릭한 게시물 번호
                currentPage: this.paging.currentPage,
                totalItems: this.paging.totalItems,
                itemsPerPage: this.paging.itemsPerPage,
                pageCountPerPageGroup: this.paging.pageCountPerPageGroup,
                
                linkArray: [],                                                  //페이징시 보여지는 번호 첫번째부터 마지막번호까지 리스트
                productSearch: this.paging.productSearch,
                productCategory: this.paging.productCategory
            }
            res.totalPageCount = Math.ceil(res.totalItems/res.itemsPerPage);                  //모든 게시물이 표시되는데 필요한 총 페이지 수
            res.seqOfPageGroup = Math.ceil(res.currentPage/res.pageCountPerPageGroup);        //화면에 보여지는게 몇번째 페이지 그룹인지 나타낸 수
            res.lastPage = res.seqOfPageGroup * res.pageCountPerPageGroup;                    //현재 화면에 보이는 마지막 페이지 번호
            res.firstPage = res.lastPage - res.pageCountPerPageGroup + 1;                     //현재 화면에 보이는 첫번째 페이지 번호
            res.nextPage = res.lastPage+1;                                                    //다음 페이지 번호 << 현재페이지에 대입해야함.
            res.prevPage = res.firstPage-1;

            if (res.lastPage > res.totalPageCount) {
                res.lastPage = res.totalPageCount;  //현재 화면에 보여질 마지막 페이지 번호가 총 페이지 수보다 크면 총페이지수를 마지막번호로 지정
            }
            for (let i = res.firstPage; i <= res.lastPage; i++) {
                res.linkArray.push(i);
            }

            //db에서 검색할 게시물 번호 범위
            res.dbEndNumber = res.currentPage * res.itemsPerPage;
            res.dbStartNumber = res.dbEndNumber - res.itemsPerPage + 1;

            return res;
        },

        breadCrumb(){
            let 상위카테고리 = [
                {name: '수입과자/기타' , parent: '과자류'},
                {name: '스낵', parent: '과자류'},
                {name: '초콜릿', parent: '과자류'},
                {name: '쿠키/비스켓', parent: '과자류'},
                {name: '기타', parent: '기타'},
                {name: '냉동식품', parent: '기타'},
                {name: '농수산물', parent: '기타'},
                {name: '기타즉석식품', parent: '라면즉석식품'},
                {name: '라면', parent: '라면즉석식품'},
                {name: '죽/스프', parent: '라면즉석식품'},
                {name: '즉석밥', parent: '라면즉석식품'},
                {name: '가정용품', parent: '생활잡화'},
                {name: '욕실용품', parent: '생활잡화'},
                {name: '위생용품', parent: '생활잡화'},
                {name: '의약외품', parent: '생활잡화'},
                {name: '일회용품', parent: '생활잡화'},
                {name: '주방용품', parent: '생활잡화'},
                {name: '건어물/안주류', parent: '식품류'},
                {name: '밀가루', parent: '식품류'},
                {name: '장류/양념류', parent: '식품류'},
                {name: '조미/소스류', parent: '식품류'},
                {name: '통조림', parent: '식품류'},
                {name: '생수/기타', parent: '커피음료'},
                {name: '음료', parent: '커피음료'},
                {name: '차류', parent: '커피음료'},
                {name: '커피', parent: '커피음료'},
            ]

            let res = 상위카테고리.find((item,i,origin) => {
                if (this.paging.productCategory == item.name) {
                    return true;
                }
            });

            //자식카테고리 값이 없다 == 현재 paging.productCategory가 ''이다 == undefined 
            if (res == undefined) {                     //없다면
                if (this.paging.categoryParent != '') { //근데 부모카테고리는 있다면 그 부모값을 리턴
                    return this.paging.categoryParent;
                }
                return "";                              //둘다없다면 '' 리턴
                
            } else {                                    //있다면 find로 찾아온 부모카테고리 값 리턴
                return res.parent;
            }
        }

    },
    actions: {
        //헤더 상품 검색
        headerSearch() {
            // const store = useStore();
            // store.rstate++;
            // this.paging.currentPage = 1;    //parent 카테고리만 클릭했을때 currentPage를 초기화해서 1페이지부터 보여질수있게한다.
            this.classVar = this.paging.currentPage;

            let param = {
                productSearch : this.paging.productSearch,
                productCategory : this.paging.productCategory,
                categoryParent : this.breadCrumb,
                dbStartNumber: this.pagingC.dbStartNumber,
                dbEndNumber: this.pagingC.dbEndNumber,
            }
            console.log('[product.js] headerSearch paging.currentPage : ', this.paging.currentPage);
            console.log('[product.js] headerSearch classVar : ', this.classVar);
            console.log('[product.js] headerSearch param : ', param);
            http.get('/productc/headerSearch', {
                params: param

            }).then((res) => {
                console.log('[product.js] headerSearch res: ', res.data)
                this.paging.totalItems = res.data.totalItems;
                this.productSearchList = res.data.result;

                this.productSearchList.forEach((item,i,origin) => {
                    origin[i].count = 1;                //상품뷰에서 장바구니 개수선택 1로 초기화
                    origin[i].popupOnOff = false;       //상품뷰에서 장바구니 클릭시 뜨는 팝업창 초기값 설정 - 클릭시 true로 바뀌고 일정시간 후 다시 false로 바뀜
                })

            }).catch(error => console.log('[product.js] headerSearch error: ', error.response.data))
        }

        //페이징이 밑으로 갈때마다 범위의 개수를 몇개식 로드해와 기존의 리스트에 추가하고 스크롤위치는 그 위치에 고정하는 방식으로 상품추가갱신 로직
        //window.scrollTo({ top: 260, behavior: 'smooth'}); //글 클릭시 맨위로 가기 참고 - messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
    },
    persist: {
        storage: window.sessionStorage,
        eanbled: true
    }

})