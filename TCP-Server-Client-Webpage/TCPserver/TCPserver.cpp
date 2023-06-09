/*
    Carter Glynn
    NEH - Assignment 6
    TCP Server
    2023-03-25
*/

#undef UNICODE

#define WIN32_LEAN_AND_MEAN

#include <windows.h>
#include <winsock2.h>
#include <ws2tcpip.h>
#include <stdlib.h>
#include <stdio.h>
#include "sqlite3.h"
#include <string>

// Need to link with Ws2_32.lib
#pragma comment (lib, "Ws2_32.lib")
// #pragma comment (lib, "Mswsock.lib")

#define DEFAULT_BUFLEN 512
#define DEFAULT_PORT "27015"
bool InsertIntoDB(SOCKET);

char name[256];
char email[512];
char postal_code[256];
char message[1024];
const char* dbLocation = "../feedback.db";

int __cdecl main(void)
{
    WSADATA wsaData;
    int iResult;

    SOCKET ListenSocket = INVALID_SOCKET;
    SOCKET ClientSocket = INVALID_SOCKET;

    struct addrinfo* result = NULL;
    struct addrinfo hints;

    int iSendResult;
    char recvbuf[DEFAULT_BUFLEN];
    int recvbuflen = DEFAULT_BUFLEN;

    // Initialize Winsock
    iResult = WSAStartup(MAKEWORD(2, 2), &wsaData);
    if (iResult != 0) {
        printf("WSAStartup failed with error: %d\n", iResult);
        return 1;
    }

    ZeroMemory(&hints, sizeof(hints));
    hints.ai_family = AF_INET;
    hints.ai_socktype = SOCK_STREAM;
    hints.ai_protocol = IPPROTO_TCP;
    hints.ai_flags = AI_PASSIVE;

    // Resolve the server address and port
    iResult = getaddrinfo(NULL, DEFAULT_PORT, &hints, &result);
    if (iResult != 0) {
        printf("getaddrinfo failed with error: %d\n", iResult);
        WSACleanup();
        return 1;
    }

    // Create a SOCKET for the server to listen for client connections.
    ListenSocket = socket(result->ai_family, result->ai_socktype, result->ai_protocol);
    if (ListenSocket == INVALID_SOCKET) {
        printf("socket failed with error: %ld\n", WSAGetLastError());
        freeaddrinfo(result);
        WSACleanup();
        return 1;
    }

    // Setup the TCP listening socket
    iResult = bind(ListenSocket, result->ai_addr, (int)result->ai_addrlen);
    if (iResult == SOCKET_ERROR) {
        printf("bind failed with error: %d\n", WSAGetLastError());
        freeaddrinfo(result);
        closesocket(ListenSocket);
        WSACleanup();
        return 1;
    }

    freeaddrinfo(result);

    iResult = listen(ListenSocket, SOMAXCONN);
    if (iResult == SOCKET_ERROR) {
        printf("listen failed with error: %d\n", WSAGetLastError());
        closesocket(ListenSocket);
        WSACleanup();
        return 1;
    }

    // Accept a client socket
    ClientSocket = accept(ListenSocket, NULL, NULL);
    if (ClientSocket == INVALID_SOCKET) {
        printf("accept failed with error: %d\n", WSAGetLastError());
        closesocket(ListenSocket);
        WSACleanup();
        return 1;
    }

    // No longer need server socket
    closesocket(ListenSocket);
    
    int i = 0, j = 0;
    char str[20];
    std::string info[4];
    // Receive until the peer shuts down the connection
    do {
        
        //iResult = recv(ClientSocket, recvbuf, recvbuflen, 0);
        iResult = 1;
        printf("gets here\n");
        if (iResult > 0) {
            printf("Collecting data\n");

            if (!InsertIntoDB(ClientSocket)) { iResult = 0; }
            else {
                iSendResult = send(ClientSocket, "Feedback inserted into database\n", strlen("Feedback inserted into database\n"), 0);
                if (iSendResult == SOCKET_ERROR) { 
                    closesocket(ClientSocket); 
                }
            }

            iSendResult = send(ClientSocket, recvbuf, iResult, 0);
            if (iSendResult == SOCKET_ERROR) {
                printf("send failed with error: %d\n", WSAGetLastError());
                closesocket(ClientSocket);
                WSACleanup();
                return 1;
            }
        }
        else if (iResult == 0)
            printf("Connection closing...\n");
        else {
            printf("recv failed with error: %d\n", WSAGetLastError());
            closesocket(ClientSocket);
            WSACleanup();
            return 1;
        }

    } while (iResult > 0);

    // shutdown the connection since we're done
    iResult = shutdown(ClientSocket, SD_SEND);
    if (iResult == SOCKET_ERROR) {
        printf("shutdown failed with error: %d\n", WSAGetLastError());
        closesocket(ClientSocket);
        WSACleanup();
        return 1;
    }

    // cleanup
    closesocket(ClientSocket);
    WSACleanup();

    return 0;
}

bool InsertIntoDB(SOCKET ClientSocket) {
    int iSendResult;
    int iResult;
    sqlite3* db;
    int connection = sqlite3_open(dbLocation, &db);
    char* errMsg = 0;
    if (connection != SQLITE_OK) {
        fprintf(stderr, "Unable to open database: %s\n", sqlite3_errmsg(db));
        sqlite3_close(db);
        return 0;
    }
    else {
        fprintf(stderr, "Opened database successfully\n");

        std::string sql = "INSERT INTO feedback (name, email, postal_code, message) VALUES (?, ?, ?, ?)";
        sqlite3_stmt* statement;
        
        connection = sqlite3_prepare_v2(db, sql.c_str(), -1, &statement, nullptr);
        
        if (connection != SQLITE_OK) {
            // handle the error
            printf("Unable to prepare SQL statement\n");
            sqlite3_close(db);
        }

        iSendResult = send(ClientSocket, "name: ", strlen("name: "), 0);
        iResult = recv(ClientSocket, name, (sizeof(name) / sizeof(char)), 0);

        iSendResult = send(ClientSocket, "email: ", strlen("email: "), 0);
        iResult = recv(ClientSocket, email, (sizeof(email) / sizeof(char)), 0);

        iSendResult = send(ClientSocket, "postal_code: ", strlen("postal_code: "), 0);
        iResult = recv(ClientSocket, postal_code, (sizeof(postal_code) / sizeof(char)), 0);

        iSendResult = send(ClientSocket, "message: ", strlen("message: "), 0);
        iResult = recv(ClientSocket, message, (sizeof(message) / sizeof(char)), 0);

        sqlite3_bind_text(statement, 1, name, (sizeof(name) / sizeof(char)), SQLITE_STATIC);
        sqlite3_bind_text(statement, 2, email, (sizeof(email) / sizeof(char)), SQLITE_STATIC);
        sqlite3_bind_text(statement, 3, postal_code, (sizeof(postal_code) / sizeof(char)), SQLITE_STATIC);
        sqlite3_bind_text(statement, 4, message, (sizeof(message) / sizeof(char)), SQLITE_STATIC);
        
        connection = sqlite3_step(statement);
        if (connection != SQLITE_OK) { 
            printf("Unable to insert row\n"); 
        }

        // Free the statement when done.
        sqlite3_finalize(statement);


        sqlite3_close(db);
        return 1;
    }
}