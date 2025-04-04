document.addEventListener('DOMContentLoaded', function() {
    // 전역 변수 설정
    const searchForm = document.querySelector('.search-form');
    const userTable = document.querySelector('.user-table table');
    const modal = document.getElementById('userDetailModal');
    const modalClose = modal.querySelector('.modal-close');

    // 테이블 체크박스 전체 선택/해제
    const selectAllCheckbox = userTable.querySelector('thead input[type="checkbox"]');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = userTable.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // 회원 상세 정보 모달 표시
    userTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-primary') && e.target.textContent === '상세') {
            const row = e.target.closest('tr');
            const userData = {
                name: row.cells[1].textContent,
                email: row.cells[2].textContent,
                phone: row.cells[3].textContent,
                memberType: row.cells[4].textContent,
                joinDate: row.cells[5].textContent,
                status: row.cells[6].textContent
            };
            showUserDetail(userData);
        }
    });

    // 회원 상태 업데이트 함수
    function updateUserStatus(userId, newStatus) {
        // TODO: API 호출하여 회원 상태 업데이트
        console.log('상태 업데이트:', userId, newStatus);
    }

    // 모달 닫기 처리
    modalClose.addEventListener('click', function() {
        modal.classList.remove('show');
    });

    // 모달 외부 클릭 시 닫기
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });

    // 페이지네이션 처리
    const pagination = document.querySelector('.pagination');
    pagination.addEventListener('click', function(e) {
        if (e.target.classList.contains('page-btn')) {
            const page = e.target.textContent;
            loadPage(page);
        }
    });

    // 페이지 로드 함수
    function loadPage(page) {
        // TODO: API 호출하여 해당 페이지의 회원 목록 조회
        console.log('페이지 로드:', page);
    }
});