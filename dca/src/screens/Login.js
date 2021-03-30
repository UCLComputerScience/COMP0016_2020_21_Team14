import React from 'react';
import {View, Image, Text, TextInput, TouchableOpacity, Platform, Button, StatusBar, StyleSheet} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import axios from 'axios';

import * as Animatable from 'react-native-animatable';
import {LinearGradient} from 'expo-linear-gradient';

import FontAwesome from 'react-native-vector-icons/FontAwesome';
import Feather from 'react-native-vector-icons/Feather';

import {useTheme} from 'react-native-paper';

const Login = ({navigation}) => {

    const [data, setData] = React.useState({
        username: '',
        password: '',
        secureTextEntry: true
    });
    
    const { colors } = useTheme();
    
    const usernameChange = (val) => {
        setData({...data, username: val})
    }

    const passwordChange = (val) => {
        setData({...data, password: val})
    }

    const asyncSet = async (key, value) => {
        try {
            await AsyncStorage.setItem(key, JSON.stringify(value))
        } catch (error) {
            console.log(error)
        }
    }
    
    const handleLogin = () => {
        const url = 'http://www.arthurmurraydcp.com/wp-json/jwt-auth/v1/token';

        const info = {
            username: data.username,
            password: data.password
        };

        axios.post(url, info)
            .then((response) => {
                asyncSet('token', response.data.token);
                asyncSet('name', response.data.user_display_name);
                asyncSet('email', response.data.user_email);
                navigation.navigate('Home');
            })
            .catch((error) => {
                console.log(error);
            });
    }

    return (
        <View style = {styles.container}>
            <StatusBar backgroundColor='#009387' barStyle="light-content"/>
            <View style = {styles.header}>
                <Image
                    source = { require('../../assets/logo.png') }
                    style = {{ resizeMode: "contain", width: 420, height: 90 }}
                />
            </View>
            <Animatable.View animation="fadeInUpBig" style = {[styles.footer, {backgroundColor: colors.background}]}>
                <Text style = {[styles.text_footer, {color: colors.text}]}>Username</Text>
                <View style = {styles.action}>
                    <FontAwesome name="user-o" color = {colors.text} size={20}/>
                    <TextInput 
                        placeholder="Username"
                        placeholderTextColor="#666666"
                        autoCapitalize="none"
                        style = {[styles.textInput, {color: colors.text}]}
                        onChangeText={(val) => usernameChange(val)}
                    />
                </View>
                <Text style = {[styles.text_footer, {color: colors.text, marginTop: 35}]}>Password</Text>
                <View style = {styles.action}>
                    <Feather name="lock" color = {colors.text} size={20}/>
                    <TextInput 
                        placeholder="Password"
                        placeholderTextColor="#666666"
                        secureTextEntry = {data.secureTextEntry ? true : false}
                        autoCapitalize="none"
                        style = {[styles.textInput, {color: colors.text}]}
                        onChangeText = {(val) => passwordChange(val)}
                    />
                </View>
                <View style = {styles.button}>
                    <TouchableOpacity style = {styles.signIn} onPress={() => {handleLogin()}}>
                        <LinearGradient style = {styles.signIn} colors={['#e7cfc8', '#e7cfc8']}>
                            <Text style = {styles.textSign}>Sign In</Text>
                        </LinearGradient>
                    </TouchableOpacity>
                </View>
            </Animatable.View>
        </View>
    );
}

export default Login;

const styles = StyleSheet.create({
    container: {
        flex: 1, 
        backgroundColor: '#e7cfc8'
    },
    header: {
        flex: 1,
        justifyContent: 'flex-end',
        paddingBottom: 50
    },
    footer: {
        flex: 3,
        backgroundColor: '#fff',
        borderTopLeftRadius: 30,
        borderTopRightRadius: 30,
        paddingHorizontal: 20,
        paddingVertical: 30
    },
    text_header: {
        color: '#fff',
        fontWeight: 'bold',
        fontSize: 30
    },
    text_footer: {
        color: '#05375a',
        fontSize: 18
    },
    action: {
        flexDirection: 'row',
        marginTop: 10,
        borderBottomWidth: 1,
        borderBottomColor: '#f2f2f2',
        paddingBottom: 5
    },
    actionError: {
        flexDirection: 'row',
        marginTop: 10,
        borderBottomWidth: 1,
        borderBottomColor: '#FF0000',
        paddingBottom: 5
    },
    textInput: {
        flex: 1,
        marginTop: Platform.OS === 'ios' ? 0 : -12,
        paddingLeft: 10,
        color: '#05375a'
    },
    errorMsg: {
        color: '#FF0000',
        fontSize: 14
    },
    button: {
        alignItems: 'center',
        marginTop: 50
    },
    signIn: {
        width: '100%',
        height: 50,
        justifyContent: 'center',
        alignItems: 'center',
        borderRadius: 10
    },
    textSign: {
        fontSize: 18,
        fontWeight: 'bold'
    }
});