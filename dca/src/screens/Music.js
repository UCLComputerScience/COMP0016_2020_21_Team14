import React from 'react';
import {View} from 'react-native';

import Posts from '../components/Posts';

const Music = ({navigation}) => {
    return (
        <View style = {{flex: 1, backgroundColor: '#E7CFC8'}}>
            <Posts navigation = {navigation} screen = {'Music'}/>
        </View>
    );
}

export default Music;
