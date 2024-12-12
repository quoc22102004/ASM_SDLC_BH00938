package org.example;

public class ArrayDuplicationDemo {
    public int[] duplicateArray(int[] arr) {
        int[] newArr = new int[arr.length]; // Tạo mảng mới cùng kích thước
        for (int i = 0; i < arr.length; i++) {
            newArr[i] = arr[i]; // Sao chép các phần tử từ arr sang newArr
        }
        return newArr;
    }
}
