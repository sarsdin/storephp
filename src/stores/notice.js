import { defineStore } from 'pinia'
import http from '@/modules/http'

export const useNoticeStore = defineStore('noticeStore', {
    state: () => {
        return {
            paging : {
                prevPage: 0,
                nextPage: 0,
                firstPage: 0,
                lastPage: 0,
                currentPage: 1,             //초기화 필요
                totalPageCount: 0,
                itemsPerPage: 5,            //초기화 필요
                pageCountPerPageGroup: 10,  //초기화 필요
                seqOfPageGroup: 0,
                totalItems: 0,              //서버로부터 받아오는 값
                currentItem: 0,             
                noticeSearch: '',
                noticeSearchType: '제목'
            },
            classVar: 1,                    //paging에서 선택된 페이지번호 css적용(bold)에 사용되는 변수. 페이지번호와 이변수 값이 같으면 true라서 :class가 적용되는 방식
            rowClickedCSSVar: 0,

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
            currentAnswerInputItemNumber : -1
            
            
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
                
                linkArray: [],
                noticeSearch: this.paging.noticeSearch,
                noticeSearchType: this.paging.noticeSearchType
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
        }
    },
    actions: {

    },
    persist: {
        storage: window.sessionStorage,
        eanbled: true
    }

})